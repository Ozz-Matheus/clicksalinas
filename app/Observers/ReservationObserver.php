<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReservationObserver
{
    public function updated(Reservation $reservation): void
    {
        // Detectamos el cambio de estado a pagado
        if ($reservation->wasChanged('status') && $reservation->status === 'paid') {
            try {
                $webhookUrl = config('services.n8n.webhook_url');

                if (! empty($webhookUrl)) {
                    Http::timeout(5)->post($webhookUrl, [
                        'task_id' => $reservation->crm_task_id,
                        'status' => 'paid',
                        'amount' => $reservation->amount,
                    ]);
                }
            } catch (\Throwable $e) {
                Log::error('Error al notificar pago a n8n desde Observer', [
                    'reservation_id' => $reservation->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
