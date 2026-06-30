<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\BoldPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class CheckoutController extends Controller
{
    // Ahora recibe el modelo inyectado gracias al Implicit Route Model Binding (por UUID)
    public function show(Reservation $reservation): View
    {
        // Si ya se pagó previamente, mostramos directo el resultado
        if ($reservation->status === 'paid') {
            return view('page.checkout-result', [
                'reference' => $reservation->reference,
                'status' => 'paid',
                'reservation' => $reservation,
            ]);
        }

        return view('page.checkout', compact('reservation'));
    }

    public function process(Reservation $reservation, BoldPaymentService $boldPayment): RedirectResponse
    {
        // Validamos de nuevo para evitar doble pago
        if ($reservation->status === 'paid') {
            return redirect()->route('checkout.show', $reservation->uuid);
        }

        // ROTACIÓN DE REFERENCIA:
        // Generamos y guardamos una nueva referencia por cada intento de pago.
        // Así Bold siempre recibe un ID fresco y el webhook lo encontrará sin problema.
        $reservation->update([
            'reference' => 'RES-'.Str::upper(Str::random(10)),
        ]);

        try {
            $paymentUrl = $boldPayment->createPaymentLink(
                reference: $reservation->reference,
                amount: $reservation->amount,
                description: 'Advance Payment - '.($reservation->service?->name ?? 'Servicio')." ({$reservation->name})",
                redirectUrl: route('checkout.result', ['reference' => $reservation->reference])
            );

            return redirect()->away($paymentUrl);

        } catch (Throwable $e) {
            return back()->with('error', 'There was a connection problem with the gateway. Please try again.');
        }
    }

    public function result(Request $request): View
    {
        $reference = $request->query('reference');
        // Capturamos el estado que envía Bold en la URL (por defecto 'pending' si no viene)
        $status = $request->query('bold-tx-status', 'pending');

        // Buscamos la reserva por su referencia para tener acceso al UUID
        $reservation = Reservation::where('reference', $reference)->first();

        return view('page.checkout-result', compact('reference', 'status', 'reservation'));
    }
}
