@extends('layout')

@section('meta-title', 'Book Service : ' . config('app.name'))

@section('content')
<div class="container-fluid container_xs-no-padding">
  <section class="section section-masthead section_pt-large text-center" data-os-animation="data-os-animation">
    <div class="section-masthead__inner container">
      <header class="row section-masthead__header justify-content-center">
        <div class="col section_mb">
          <h1 class="js-text-to-fly split-text js-split-text section-masthead__heading">
            Book Session
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
            <form class="form form-contact" action="{{ route('checkout.process') }}" method="POST">
              @csrf
            @if(session('error'))
              <div class="alert alert-danger" style="color: red; margin-bottom: 20px;">
                {{ session('error') }}
              </div>
            @endif
              <div class="form__heading">
                <h2 class="form__heading-title margin-bottom">Complete your details to reserve</h2>
              </div>
              <div class="row form__row">
                <div class="col-lg-12 form__col">
                  <label class="input-float">
                    <select class="input-float__input" name="service_id" required>
                      <option value="" disabled {{ old('service_id') ? '' : 'selected' }}>
                        Select a service...
                      </option>

                      @foreach($services as $svc)
                        <option value="{{ $svc->id }}" 
                          {{ old('service_id') == $svc->id || (isset($preselectedSlug) && $preselectedSlug === $svc->slug) ? 'selected' : '' }}>
                          {{ $svc->name }}
                        </option>
                      @endforeach
                    </select>

                    <span class="input-float__label" style="top: -10px;">
                      Service to book
                    </span>

                    @error('service_id')
                      <span class="form__error">{{ $message }}</span>
                    @enderror
                  </label>
                </div>
              </div>

              <div class="row form__row">
                <div class="col-lg-12 form__col">
                  <label class="input-float">
                    <input type="text" class="input-float__input" name="name" value="{{ old('name') }}" required>
                    <span class="input-float__label">Full name</span>

                    @error('name')
                      <span class="form__error">{{ $message }}</span>
                    @enderror
                  </label>
                </div>

                <div class="col-lg-6 form__col">
                  <label class="input-float">
                    <input type="email" class="input-float__input" name="email" value="{{ old('email') }}" required>
                    <span class="input-float__label">Email address</span>

                    @error('email')
                      <span class="form__error">{{ $message }}</span>
                    @enderror
                  </label>
                </div>

                <div class="col-lg-6 form__col">
                  <label class="input-float">
                    <input type="tel" class="input-float__input" name="phone" value="{{ old('phone') }}" required>
                    <span class="input-float__label">Phone number</span>

                    @error('phone')
                      <span class="form__error">{{ $message }}</span>
                    @enderror
                  </label>
                </div>
              </div>

              <div class="row form__row">
                <div class="col form__col form__col_submit">
                  <button class="button button_solid button_accent-secondary-2 button_fullwidth" type="submit">
                    Pay Secure Deposit with Bold
                  </button>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </section>
  </div>
</div>
@stop