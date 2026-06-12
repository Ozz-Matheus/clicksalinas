<div class="container-fluid container_xs-no-padding">
    <!-- section MASTHEAD -->
    <section class="section section-masthead section_pt-large text-center" data-os-animation="data-os-animation">
      <div class="section-masthead__inner container">
        <header class="row section-masthead__header justify-content-center">
          <div class="col section_mb">
            <h1 class="js-text-to-fly split-text js-split-text section-masthead__heading" data-split-text-type="lines, words, chars" data-split-text-set="chars">
                Contacts
            </h1>
            <div class="section__headline"></div>
          </div>
        </header>
      </div>
    </section>
    <!-- - section MASTHEAD -->
    <!-- section FORM -->
    <div class="bg-white">
      <section class="section section-form text-center section_pb-small section_pt-xsmall">
        <div class="container border-radius  bg-off-white">
          <div class="row justify-content-center">
            <div class="col-sm-10 {{ session()->has('flash') ? 'sent' : '' }}">
              <form class="form form-contact" action="{{ route('mail.sent') }}" method="POST">
                @csrf
                <div class="form__heading">
                  <h2>{{ $page->cover_title }}</h2>
                    <div class="title h6 margin-bottom">
                      {!! $page->cover_paragraph !!}
                    </div>
                </div>
                <div class="row form__row">
                  <div class="col-lg-12 form__col">
                    <label class="input-float">
                        <input type="text" class="input-float__input" name="name" value="{{ old('name') }}"><span class="input-float__label">Name</span>
                        @error('name')
                            <span class="form__error">{{ $message }}</span>
                        @enderror
                    </label>
                  </div>
                  <div class="col-lg-12 form__col">
                    <label class="input-float">
                      <input type="email" class="input-float__input" name="email" value="{{ old('email') }}" ><span class="input-float__label">Email</span>
                      @error('email')
                            <span class="form__error">{{ $message }}</span>
                        @enderror
                    </label>
                  </div>
                  <div class="col-lg-4 form__col">
                    <label class="input-float">
                        <input type="tel" id="phone_visible" class="input-float__input" value="{{ old('phone') }}">
                        
                        <input type="hidden" name="phone" id="phone_hidden" value="{{ old('phone') }}">
                        
                        <span class="input-float__label" style="z-index: 5;">Phone</span>
                        @error('phone')
                            <span class="form__error">{{ $message }}</span>
                        @enderror
                    </label>
                  </div>
                </div>
                <div class="row form__row">
                  <div class="col form__col">
                    <label class="input-float">
                      <textarea class="input-float__input input-float__input_textarea" name="message">{{ old('message') }}</textarea><span class="input-float__label">Message</span>
                      @error('message')
                            <span class="form__error">{{ $message }}</span>
                        @enderror
                    </label>
                  </div>
                </div>
                <div class="row form__row">
                    <div class="col form__col">
                      <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                      <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site') }}"></div>
                      @error('g-recaptcha-response')
                          <span class="form__error">{{ $message }}</span>
                      @enderror
                    </div>
                </div>
                <div class="row form__row">
                  <div class="col form__col form__col_submit">
                    <button class="button button_solid button_accent-secondary-2 button_fullwidth" type="submit">Submit</button>
                  </div>
                </div>
              </form>
              <div id="response">
                @if( session()->has('flash') )
                <h3>
                      {{ session('flash') }}
                </h3>
                @endif
              </div><!-- /. response -->
            </div>
          </div>
        </div>
      </section>
    </div>
    <!-- - section FORM -->
    <!-- section CONTACTS -->
    <section class="section section-contacts bg-white section_pb">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-3">
            <div class="figure-contact">
              <div class="figure-contact__icon material-icons">phone</div>
              <div class="figure-contact__item">
                <a href="tel:+573014171660" target="_blank" rel="noopener">+57 (301) 4171660</a>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="figure-contact">
              <div class="figure-contact__icon material-icons">
                <li class="fa fa-whatsapp"></li>
              </div>
              <div class="figure-contact__item">
                <a href="https://wa.me/573014171660?text=Hola%20ClickSalinas,%20vi%20su%20sitio%20web%20y%20los%20contacto%20para%20conocer%20m%C3%A1s%20sobre%20sus%20servicios."
                  target="_blank"
                  rel="noopener">
                  WhatsApp
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="figure-contact">
              <div class="figure-contact__icon material-icons">
                <li class="fa fa-comments"></li>
              </div>
              <div class="figure-contact__item"><a href="https://www.messenger.com/t/clicksalinas.photo" target="_blank" rel="noopener">Messenger</a></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- - section CONTACTS -->
  </div>

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/css/intlTelInput.css">
    <style>
        /* Ajustes base de la librería */
        .iti { width: 100%; }
        .iti__country-list { text-align: left; z-index: 99; color: #333; }
        .iti__flag-container { z-index: 10; }

        .iti__country-container {
            left: 56px !important; 
        }
        .iti__tel-input {
            padding-left: 102px !important; /* Ajusta este valor según el ancho de tu bandera y código de país */
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/js/intlTelInput.min.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const visibleInput = document.querySelector("#phone_visible");
        const hiddenInput = document.querySelector("#phone_hidden");
        
        const iti = window.intlTelInput(visibleInput, {
          initialCountry: "us",
          preferredCountries: ["co", "mx", "us", "es"],
          separateDialCode: true,
          utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/js/utils.js",
        });

        // Sincroniza el número validado hacia el campo oculto
        const updateHiddenField = () => {
            if (visibleInput.value.trim() !== "") {
                // iti.getNumber() extrae el prefijo (+57) y el número
                hiddenInput.value = iti.getNumber(); 
            } else {
                hiddenInput.value = "";
            }
        };

        // Disparamos la sincronización cada vez que el usuario interactúa
        visibleInput.addEventListener('input', updateHiddenField);
        visibleInput.addEventListener('countrychange', updateHiddenField);
      });
    </script>
@endpush