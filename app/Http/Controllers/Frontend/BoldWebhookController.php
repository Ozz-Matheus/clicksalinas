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
        // 1. Verificación de Seguridad estricta
        $secretKey = (string) config('services.bold.webhook_secret', '');

        $signature = $request->header('x-bold-signature');
        $rawBody = $request->getContent();
        $hashed = hash_hmac('sha256', base64_encode($rawBody), $secretKey);

        if (! hash_equals($hashed, (string) $signature)) {
            Log::warning('Webhook Bold: Firma inválida detectada', ['ip' => $request->ip()]);

            return response()->json(['message' => 'Invalid signature'], 400);
        }

        // 2. Extracción segura del payload
        $payload = json_decode($rawBody, true);
        if (! is_array($payload)) {
            return response()->json(['message' => 'Malformed JSON payload'], 400);
        }

        $type = data_get($payload, 'type');
        $reference = data_get($payload, 'data.metadata.reference');

        Log::info('Webhook Bold recibido', [
            'type' => $type,
            'reference' => $reference,
        ]);

        if (! $reference) {
            return response()->json(['message' => 'Reference not found in payload'], 400);
        }

        // 3. Mapeo de estados
        $statusMapping = [
            'SALE_APPROVED' => 'paid',
            'SALE_REJECTED' => 'rejected',
            'VOID_APPROVED' => 'voided',
            'VOID_REJECTED' => 'void_rejected',
        ];

        $newStatus = $statusMapping[$type] ?? null;

        if (! $newStatus) {
            Log::warning('Webhook Bold: Tipo de evento desconocido', ['type' => $type, 'reference' => $reference]);

            return response()->json(['message' => 'ok'], 200); // Retornamos 200 para que Bold no reintente eventos no soportados
        }

        // 4. Búsqueda e Idempotencia
        $reservation = Reservation::firstWhere('reference', $reference);

        if (! $reservation) {
            Log::warning('Webhook Bold: Reserva no encontrada', [
                'reference' => $reference,
            ]);

            return response()->json(['message' => 'ok'], 200);
        }

        // Si el estado actual ya es el que vamos a aplicar, evitamos la consulta a DB
        if ($reservation->status === $newStatus) {
            Log::info('Webhook Bold ignorado: estado ya procesado', [
                'reference' => $reference,
                'status' => $reservation->status,
                'event_type' => $type,
            ]);

            return response()->json(['message' => 'Already processed'], 200);
        }

        // 5. Actualización
        $reservation->update(['status' => $newStatus]);
        Log::info("Reserva actualizada a estado: {$newStatus}", ['reference' => $reference]);

        return response()->json(['message' => 'ok'], 200);
    }
}
