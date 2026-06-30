<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessCheckoutRequest;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function voidReservation(Request $request): JsonResponse
    {
        $request->validate(['crm_task_id' => 'required|string']);

        $reservation = Reservation::where('crm_task_id', $request->crm_task_id)->first();

        if ($reservation && $reservation->status === 'pending') {
            $reservation->update(['status' => 'voided']);

            return response()->json(['message' => 'Reserva anulada correctamente.']);
        }

        return response()->json(['message' => 'La reserva no existe o ya fue procesada.'], 400);
    }
}
