<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class BoldPaymentService
{
    public function __construct(
        private readonly string $apiKey,
        private readonly string $endpoint
    ) {}

    /**
     * Genera un enlace de pago en Bold.
     */
    public function createPaymentLink(string $reference, int $amount, string $description, string $redirectUrl): string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'x-api-key '.$this->apiKey,
            ])
                ->timeout(5)
                ->post("{$this->endpoint}/online/link/v1", [
                    'amount_type' => 'CLOSE',
                    'amount' => [
                        'currency' => 'COP',
                        'total_amount' => $amount,
                    ],
                    'description' => $description,
                    'reference' => $reference,
                    'callback_url' => $redirectUrl,
                    'redirect_url' => $redirectUrl,
                ]);

            if ($response->failed()) {
                Log::error('Bold API Error', [
                    'endpoint' => "{$this->endpoint}/online/link/v1",
                    'status' => $response->status(),
                    'response' => $response->json() ?? $response->body(),
                    'reference' => $reference,
                ]);

                throw new Exception('La respuesta de Bold no fue exitosa.');
            }

            // Extracción limpia usando notación de puntos de Laravel
            $paymentUrl = $response->json('payload.url');

            // Mantenemos este manejo robusto de errores por si Bold cambia su API en el futuro
            if (! $paymentUrl) {
                Log::error('Estructura desconocida en la respuesta de Bold', ['response' => $response->json()]);
                throw new Exception('No se encontró la URL en la respuesta de la pasarela.');
            }

            return $paymentUrl;

        } catch (Throwable $e) {
            Log::error('Fallo crítico al conectar con Bold', ['exception' => $e->getMessage()]);
            throw new Exception('No fue posible procesar el pago en este momento.');
        }
    }
}
