<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessCheckoutRequest; // No olvides importar la clase
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;

class N8nCheckoutController extends Controller
{
    public function store(ProcessCheckoutRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $reservation = Reservation::updateOrCreate(
            ['crm_task_id' => $validated['crm_task_id']],
            [
                'service_id' => $validated['service_id'] ?? null,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'amount' => $validated['amount'],
                'status' => 'pending',
            ]
        );

        return response()->json([
            'message' => 'Checkout generado con éxito',
            'checkout_url' => route('checkout.show', $reservation->uuid),
        ], 201);
    }
}
