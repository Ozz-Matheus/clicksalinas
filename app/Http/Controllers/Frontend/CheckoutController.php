<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessCheckoutRequest;
use App\Models\Reservation;
use App\Models\Service;
use App\Services\BoldPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class CheckoutController extends Controller
{
    public function show(Request $request): View
    {
        $services = Service::all();
        // Si mandan ?service=slug en la URL, lo capturamos para preseleccionar
        $preselectedSlug = $request->query('service');

        return view('page.checkout', compact('services', 'preselectedSlug'));
    }

    public function process(ProcessCheckoutRequest $request, BoldPaymentService $boldPayment): RedirectResponse
    {
        $validated = $request->validated();

        // Obtenemos el servicio a partir del ID que viene del formulario
        $service = Service::findOrFail($validated['service_id']);

        $reference = 'RES-'.Str::upper(Str::random(10));
        $advanceAmount = 50000;

        $reservation = Reservation::create([
            'reference' => $reference,
            'service_id' => $service->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'amount' => $advanceAmount,
            'status' => 'pending',
        ]);

        try {
            $paymentUrl = $boldPayment->createPaymentLink(
                reference: $reservation->reference,
                amount: $reservation->amount,
                description: "Advance Payment - {$service->name} ({$reservation->name})",
                redirectUrl: route('checkout.success', ['reference' => $reservation->reference])
            );

            return redirect()->away($paymentUrl);

        } catch (Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'There was a connection problem with the gateway. Please try again.');
        }
    }

    public function success(Request $request): View
    {
        // Capturamos la referencia que viene en la URL para mostrársela al cliente
        $reference = $request->query('reference');

        return view('page.checkout-success', compact('reference'));
    }
}
