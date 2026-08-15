@extends('layout')

@section('meta-title', 'Reservation Result : ' . config('app.name'))
@section('meta-robots', 'noindex, follow')

@section('content')
<div class="bg-white">
    <section class="section text-center section_pb-small section_pt-xsmall">
      <div class="container border-radius bg-off-white" style="padding: 40px;">
        <div class="row justify-content-center">
          <div class="col-sm-8">
            
            @if(strtoupper($status) === 'APPROVED' || strtoupper($status) === 'PAID')
                <div style="font-size: 48px; color: #10B981; margin-bottom: 20px;">✓</div>
                <h2 style="margin-bottom: 20px;">Payment Confirmed</h2>
                <p style="font-size: 18px; color: #666; margin-bottom: 30px;">
                   Your reservation has been processed successfully. We will notify you shortly.
                </p>
            @else
                <div style="font-size: 48px; color: #EF4444; margin-bottom: 20px;">✕</div>
                <h2 style="margin-bottom: 20px;">Payment could not be processed</h2>
                <p style="font-size: 18px; color: #666; margin-bottom: 30px;">
                   The transaction status is <strong>{{ strtoupper($status) }}</strong>. Please try again or use a different payment method.
                </p>
            @endif

            @if($reference)
            <div style="background-color: #f3f4f6; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                <p style="margin: 0; color: #374151; font-weight: bold;">Your reference code is:</p>
                <p style="margin: 0; font-size: 24px; color: #111827; font-family: monospace;">
                  {{ $reference }}
                </p>
            </div>
            @endif

            @if(strtoupper($status) === 'APPROVED' || strtoupper($status) === 'PAID')
                <a href="{{ route('pages.home') }}" class="button button_solid button_accent-secondary-2">
                    Back to Home
                </a>
            @else
                @if(isset($reservation) && $reservation)
                    <a href="{{ route('checkout.show', $reservation->uuid) }}" class="button button_solid button_accent-secondary-2">
                        Try Again
                    </a>
                @else
                    <a href="{{ route('pages.home') }}" class="button button_solid button_accent-secondary-2">
                        Back to Home
                    </a>
                @endif
            @endif

          </div>
        </div>
      </div>
    </section>
</div>
@stop