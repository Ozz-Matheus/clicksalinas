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
            $response = Http::withToken($this->apiKey)
                ->timeout(5)
                ->post("{$this->endpoint}/payment-link", [
                    'amount' => $amount,
                    'currency' => 'COP',
                    'description' => $description,
                    'reference' => $reference,
                    'redirect_url' => $redirectUrl,
                ]);

            if ($response->failed()) {
                Log::error('Bold API Error', [
                    'status' => $response->status(),
                    'response' => $response->json(),
                    'reference' => $reference,
                ]);

                throw new Exception('La respuesta de Bold no fue exitosa.');
            }

            // Asumiendo que la API de Bold retorna la URL en data.payment_url
            return $response->json('data.payment_url');

        } catch (Throwable $e) {
            Log::error('Fallo crítico al conectar con Bold', ['exception' => $e->getMessage()]);
            throw new Exception('No fue posible procesar el pago en este momento.');
        }
    }
}
