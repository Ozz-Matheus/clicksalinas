<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BoldWebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        // 1. Verificación de Seguridad (Firma HMAC-SHA256)
        $signature = $request->header('x-bold-signature');
        $rawBody = $request->getContent(); // Necesitamos el body crudo como texto
        $encoded = base64_encode($rawBody);

        $secretKey = config('services.bold.webhook_secret', '');
        $hashed = hash_hmac('sha256', $encoded, $secretKey);

        if (! hash_equals($hashed, (string) $signature)) {
            Log::warning('Webhook Bold: Firma inválida detectada', ['ip' => $request->ip()]);

            return response()->json(['message' => 'Invalid signature'], 400);
        }

        // 2. Extraer datos según el esquema oficial de Bold
        $payload = json_decode($rawBody, true);

        $type = $payload['type'] ?? null;
        $reference = $payload['data']['metadata']['reference'] ?? null;

        if (! $reference) {
            return response()->json(['message' => 'Reference not found in payload'], 400);
        }

        // 3. Buscar la reserva en nuestra BD
        $reservation = Reservation::where('reference', $reference)->first();

        if (! $reservation) {
            Log::warning('Webhook Bold: Reserva no encontrada', ['reference' => $reference]);

            return response()->json(['message' => 'Reservation not found'], 404);
        }

        // 4. Idempotencia: Si ya está pagada, respondemos 200 inmediatamente
        if ($reservation->status === 'paid') {
            return response()->json(['message' => 'Already processed'], 200);
        }

        // 5. Actualizar el estado basado en el 'type' del evento
        if ($type === 'SALE_APPROVED') {
            $reservation->update(['status' => 'paid']);
            Log::info('Reserva pagada exitosamente', ['reference' => $reference]);

        } elseif (in_array($type, ['SALE_REJECTED', 'VOID_APPROVED', 'VOID_REJECTED'])) {
            $reservation->update(['status' => 'failed']);
            Log::info('Reserva rechazada o anulada', ['reference' => $reference, 'type' => $type]);
        }

        // Bold exige un 200 OK rápido para no reintentar
        return response()->json(['message' => 'ok'], 200);
    }
}
