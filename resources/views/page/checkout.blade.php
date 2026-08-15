@extends('layout')

@section('meta-title', 'Confirm Reservation : ' . config('app.name'))
@section('meta-robots', 'noindex, follow')

@section('content')
    <div class="container-fluid container_xs-no-padding">
        <section class="section section-masthead section_pt-large text-center" data-os-animation="data-os-animation">
            <div class="section-masthead__inner container">
                <header class="row section-masthead__header justify-content-center">
                    <div class="col section_mb">
                        <h1 class="js-text-to-fly split-text js-split-text section-masthead__heading">
                            Confirm Reservation
                        </h1>
                        <div class="section__headline"></div>
                    </div>
                </header>
            </div>
        </section>

        <div class="bg-white">
            <section class="section section-form text-center section_pb-small section_pt-xsmall">
                <div class="container border-radius bg-off-white">
                    <div class="row justify-content-center">
                        <div class="col-sm-10">

                            <form class="form form-contact" action="{{ route('checkout.process', $reservation->uuid) }}"
                                method="POST">
                                @csrf

                                @if (session('error'))
                                    <div class="alert alert-danger" style="color: red; margin-bottom: 20px;">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div class="row form__row">

                                    <div class="col-lg-6 form__col">
                                        <label class="input-float">
                                            <input type="text" class="input-float__input"
                                                value="{{ $reservation->name }}" readonly>
                                            <span class="input-float__label">Name</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-6 form__col">
                                        <label class="input-float">
                                            <input type="email" class="input-float__input"
                                                value="{{ $reservation->email }}" readonly>
                                            <span class="input-float__label">Email Address</span>
                                        </label>
                                    </div>

                                    @if ($reservation->service)
                                        <div class="col-lg-6 form__col">
                                            <label class="input-float">
                                                <input type="text" class="input-float__input"
                                                    value="{{ $reservation->service->name }}" readonly>
                                                <span class="input-float__label">Service</span>
                                            </label>
                                        </div>
                                    @endif
                                    <div class="col-lg-{{ $reservation->service ? '6' : '12' }} form__col">
                                        <label class="input-float">
                                            <input type="text" class="input-float__input"
                                                value="$ {{ number_format($reservation->amount, 0, ',', '.') }} COP"
                                                readonly>
                                            <span class="input-float__label">Amount to Pay</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="row form__row">
                                    <div class="col form__col form__col_submit">
                                        <button class="button button_solid button_accent-secondary-2 button_fullwidth"
                                            type="submit">
                                            Pay Secure Deposit with Bold
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>
    </div>
@stop
