@extends('layout')

@section('meta-title', 'Reservation in Progress : ' . config('app.name'))

@section('content')
<div class="container-fluid container_xs-no-padding">
  <section class="section section-masthead section_pt-large text-center" data-os-animation="data-os-animation">
    <div class="section-masthead__inner container">
      <header class="row section-masthead__header justify-content-center">
        <div class="col section_mb">
          <h1 class="js-text-to-fly split-text js-split-text section-masthead__heading">
            Thank You for Your Preference!
          </h1>
          <div class="section__headline"></div>
        </div>
      </header>
    </div>
  </section>

  <div class="bg-white">
    <section class="section text-center section_pb-small section_pt-xsmall">
      <div class="container border-radius bg-off-white" style="padding: 40px;">
        <div class="row justify-content-center">
          <div class="col-sm-8">
            
            <div style="font-size: 48px; color: #10B981; margin-bottom: 20px;">
                ✓
            </div>
            
            <h2 style="margin-bottom: 20px;">Your payment process has been completed</h2>
            
            <p style="font-size: 18px; color: #666; margin-bottom: 30px;">
              We have received your reservation request. The payment gateway will automatically notify us within the next few minutes once the transaction is confirmed by your bank.
            </p>

            @if($reference)
            <div style="background-color: #f3f4f6; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                <p style="margin: 0; color: #374151; font-weight: bold;">
                  Your reference code is:
                </p>

                <p style="margin: 0; font-size: 24px; color: #111827; font-family: monospace;">
                  {{ $reference }}
                </p>
            </div>
            @endif

            <p style="margin-bottom: 40px;">
              Once the payment is confirmed, we will contact you to finalize the details.
            </p>

            <a href="{{ route('pages.home') }}" class="button button_solid button_accent-secondary-2">
              Back to Home
            </a>

          </div>
        </div>
      </div>
    </section>
  </div>
</div>
@stop