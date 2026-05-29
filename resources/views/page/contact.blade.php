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
                  <div class="col-lg-4 form__col">
                    <label class="input-float">
                        <input type="text" class="input-float__input" name="name" value="{{ old('name') }}"><span class="input-float__label">Name</span>
                        @error('name')
                            <span class="form__error">{{ $message }}</span>
                        @enderror
                    </label>
                  </div>
                  <div class="col-lg-4 form__col">
                    <label class="input-float">
                      <input type="email" class="input-float__input" name="email" value="{{ old('email') }}" ><span class="input-float__label">Email</span>
                      @error('email')
                            <span class="form__error">{{ $message }}</span>
                        @enderror
                    </label>
                  </div>
                  <div class="col-lg-4 form__col">
                    <label class="input-float">
                        <input type="text"  class="input-float__input" name="phone" value="{{ old('phone') }}"><span class="input-float__label">Phone</span>
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
                    {{-- {!! NoCaptcha::display() !!}  --}}
                    {{-- {!! NoCaptcha::renderJs() !!}  --}}
                    {{-- 
                        @error('g-recaptcha-response')
                            <span class="form__error">{{ $message }}</span>
                        @enderror
                    --}}
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
                <a href="https://wa.me/573014171660?text=Hola%20ClickSalinas,%20los%20contacto%20para%20m%C3%A1s%20informaci%C3%B3n%20sobre%20sus%20servicios!" target="_blank" rel="noopener">
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
              <div class="figure-contact__item"><a href="https://www.messenger.com/t/clicksalinas16" target="_blank" rel="noopener">Messenger</a></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- - section CONTACTS -->
  </div>