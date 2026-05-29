<div class="container-full">

<!-- section FULLSCREEN SLIDER -->
<section class="section section-fullscreen-slider section-fullheight" data-os-animation="data-os-animation">
  <div class="section-fullheight__inner section-fullscreen-slider__inner">
    <div class="slider slider-fullscreen js-slider-fullscreen">

      <div class="container-fluid swiper-container slider-fullscreen__content slider-fullscreen__content_centered js-slider-fullscreen__content text-center">
        <div class="swiper-wrapper">

          <div class="swiper-slide slider-fullscreen__content-slide">
            <div class="slider-fullscreen__content-inner">
              <header class="slider-fullscreen__header"><a class="slider__link" href="{{ $featured_images->photoshootUrl ? url('photographs/'.$featured_images->photoshootUrl->url) : '#' }}" data-pjax-link="flyingHeading" aria-label="View {{ $featured_images->photoshootUrl ? $featured_images->photoshootUrl->name : 'Photoshoot' }} portfolio">
                  <h1 class="slider__heading split-text js-text-to-fly js-split-text" data-split-text-type="lines, words, chars" data-split-text-set="chars">{{ $featured_images->photoshootUrl ? $featured_images->photoshootUrl->name : 'Photoshoot' }}</h1></a></header>
              <div class="slider-fullscreen__wrapper-button slider__wrapper-button"><a class="link-arrow" href="{{ $featured_images->photoshootUrl ? url('photographs/'.$featured_images->photoshootUrl->url) : url('/contact') }}" aria-label="Book a photography session" data-pjax-link="flyingHeading">
                  <div class="link-arrow__label">Book a Session</div>
                  <div class="link-arrow__icon material-icons" aria-hidden="true">keyboard_arrow_right</div></a></div>
            </div>
          </div>

          <div class="swiper-slide slider-fullscreen__content-slide">
            <div class="slider-fullscreen__content-inner">
              <header class="slider-fullscreen__header"><a class="slider__link" href="{{ $featured_images->weddingUrl ? url('photographs/'.$featured_images->weddingUrl->url) : '#' }}" data-pjax-link="flyingHeading" aria-label="View {{ $featured_images->weddingUrl ? $featured_images->weddingUrl->name : 'Weddings' }} portfolio">
                  <h2 class="h1 slider__heading split-text js-text-to-fly js-split-text" data-split-text-type="lines, words, chars" data-split-text-set="chars">{{ $featured_images->weddingUrl ? $featured_images->weddingUrl->name : 'Weddings' }}</h2></a></header>
              <div class="slider-fullscreen__wrapper-button slider__wrapper-button"><a class="link-arrow" href="{{ $featured_images->weddingUrl ? url('photographs/'.$featured_images->weddingUrl->url) : '#' }}" title="{{ $featured_images->weddingUrl ? $featured_images->weddingUrl->name : 'See more' }}" aria-label="See more about weddings" data-pjax-link="flyingHeading">
                  <div class="link-arrow__label">See more</div>
                  <div class="link-arrow__icon material-icons" aria-hidden="true">keyboard_arrow_right</div></a></div>
            </div>
          </div>

          <div class="swiper-slide slider-fullscreen__content-slide">
            <div class="slider-fullscreen__content-inner">
              <header class="slider-fullscreen__header"><a class="slider__link" href="{{ $featured_images->commercialUrl ? url('photographs/'.$featured_images->commercialUrl->url) : '#' }}" data-pjax-link="flyingHeading" aria-label="View {{ $featured_images->commercialUrl ? $featured_images->commercialUrl->name : 'Commercials' }} portfolio">
                  <h3 class="h1 slider__heading split-text js-text-to-fly js-split-text" data-split-text-type="lines, words, chars" data-split-text-set="chars">{{ $featured_images->commercialUrl ? $featured_images->commercialUrl->name : 'Commercials' }}</h3></a></header>
              <div class="slider-fullscreen__wrapper-button slider__wrapper-button"><a class="link-arrow" href="{{ $featured_images->commercialUrl ? url('photographs/'.$featured_images->commercialUrl->url) : '#' }}" title="{{ $featured_images->commercialUrl ? $featured_images->commercialUrl->name : 'See more' }}" aria-label="See more about commercials" data-pjax-link="flyingHeading">
                  <div class="link-arrow__label">See more</div>
                  <div class="link-arrow__icon material-icons" aria-hidden="true">keyboard_arrow_right</div></a></div>
            </div>
          </div>

        </div>
      </div>
      <!-- - slider content -->
      <div class="swiper-container slider-fullscreen__images js-slider-fullscreen__images" data-overlap-factor="0.33">
        <div class="swiper-wrapper">

          <div class="swiper-slide slider__images-slide">
            <div class="slider__images-slide-inner">
              <img src="{{ $main_image }}" alt="Professional Photographer in Cartagena de Indias" fetchpriority="high" loading="eager" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; z-index:0;">
              </div>
          </div>

          <div class="swiper-slide slider__images-slide">
            <div class="slider__images-slide-inner">
              <div class="slider__bg swiper-lazy" role="img" aria-label="Wedding photography in Cartagena" data-background="{{ $featured_images->weddingLast ? asset($featured_images->weddingLast->url) : asset('/multimedia/demo/image-1.jpg') }}" title="{{ $featured_images->weddingLast ? $featured_images->weddingLast->name : config('app.name') }}"></div>
            </div>
          </div>

          <div class="swiper-slide slider__images-slide">
            <div class="slider__images-slide-inner">
              <div class="slider__bg swiper-lazy" role="img" aria-label="Commercial photography in Cartagena" data-background="{{ $featured_images->commercialLast ? asset($featured_images->commercialLast->url) : asset('/multimedia/demo/image-3.jpg') }}"></div>
            </div>
          </div>
        <div class="slider__overlay overlay"></div>
        <!-- - slider overlay -->
        </div>
      <!-- - slider images -->
      <div class="slider__footer">
        <div class="container-fluid">
          <div class="row justify-content-between align-items-center">
            <div class="col-auto text-left slider__footer-col">
              <div class="slider__arrows slider-halfscreen__arrows">
                <div class="slider__arrow slider-halfscreen__arrow_prev js-slider-fullscreen__prev" aria-label="Previous slide" role="button"><i class="material-icons" aria-hidden="true">keyboard_arrow_up</i></div>
                <div class="slider__arrows-divider"></div>
                <div class="slider__arrow slider-halfscreen__arrow_next js-slider-fullscreen__next" aria-label="Next slide" role="button"><i class="material-icons" aria-hidden="true">keyboard_arrow_down</i></div>
              </div>
            </div>
             <!-- - slider nav arrows -->
            <div class="col-auto text-center slider__footer-col d-none d-md-block">
              <div class="slider__dots js-slider-dots">
                <div class="slider__dot slider__dot_active"><svg viewBox="0 0 152 152" version="1.1" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g transform="translate(-134.000000, -98.000000)"><path class="circle" d="M135,174a75,75 0 1,0 150,0a75,75 0 1,0 -150,0"></path></g></g></svg></div>
                <div class="slider__dot"><svg viewBox="0 0 152 152" version="1.1" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g transform="translate(-134.000000, -98.000000)"><path class="circle" d="M135,174a75,75 0 1,0 150,0a75,75 0 1,0 -150,0"></path></g></g></svg></div>
                <div class="slider__dot"><svg viewBox="0 0 152 152" version="1.1" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g transform="translate(-134.000000, -98.000000)"><path class="circle" d="M135,174a75,75 0 1,0 150,0a75,75 0 1,0 -150,0"></path></g></g></svg></div>
                <div class="slider__dot"><svg viewBox="0 0 152 152" version="1.1" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g transform="translate(-134.000000, -98.000000)"><path class="circle" d="M135,174a75,75 0 1,0 150,0a75,75 0 1,0 -150,0"></path></g></g></svg></div>
              </div>
            </div>
            <!-- - slider nav dots -->
            <div class="col-auto text-right slider__footer-col">
              <div class="slider__progress">
                <div class="swiper-container slider__counter slider__counter_current js-slider-fullscreen__counter-current"><div class="swiper-wrapper"></div></div>
                <div class="slider__counter-divider"></div>
                <div class="slider__counter slider__counter_total js-slider-fullscreen__counter-total">001</div>
              </div>
            </div>
            <!-- - slider counter -->
          </div>
        </div>
      </div>
      <!-- - slider footer (controls) -->
      </div>
  </div>
</section>
<!-- - section FULLSCREEN SLIDER -->
  </div>