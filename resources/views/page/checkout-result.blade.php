@extends('layout')

@section('meta-title', 'Reservation Result : ' . config('app.name'))

@section('content')
<div class="bg-white">
    <section class="section text-center section_pb-small section_pt-xsmall">
      <div class="container border-radius bg-off-white" style="padding: 40px;">
        <div class="row justify-content-center">
          <div class="col-sm-8">
            
            @if($status === 'failed' || $status === 'rejected')
                <div style="font-size: 48px; color: #EF4444; margin-bottom: 20px;">
                    ✕
                </div>
                <h2 style="margin-bottom: 20px;">Your payment could not be processed</h2>
                <p style="font-size: 18px; color: #666; margin-bottom: 30px;">
                   The payment gateway rejected the transaction or it was canceled. Please try again or use a different payment method.
                </p>
            @else
                <div style="font-size: 48px; color: #10B981; margin-bottom: 20px;">
                    ✓
                </div>
                <h2 style="margin-bottom: 20px;">Payment process completed</h2>
                <p style="font-size: 18px; color: #666; margin-bottom: 30px;">
                   We have received your reservation request. The payment gateway will notify us within the next few minutes once your bank confirms the transaction.
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

            <a href="{{ route('checkout.show') }}" class="button button_solid button_accent-secondary-2">
              Try Again
            </a>

          </div>
        </div>
      </div>
    </section>
  </div>
</div>
@stop