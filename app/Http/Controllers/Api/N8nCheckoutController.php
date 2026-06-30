<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class N8nCheckoutController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'crm_task_id' => ['required', 'string'],
            'service_id' => ['required', 'exists:services,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'amount' => ['required', 'integer', 'min:50000'],
        ]);

        // updateOrCreate nos da idempotencia: si n8n falla y reintenta la misma petición,
        // no creamos reservas duplicadas en base de datos.
        $reservation = Reservation::updateOrCreate(
            ['crm_task_id' => $validated['crm_task_id']],
            [
                'service_id' => $validated['service_id'],
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
