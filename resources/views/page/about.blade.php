<div class="container-fluid container_xs-no-padding">
  <!-- section MASTHEAD -->
  <section class="section section-masthead section_pt-large section_pb-small text-center bg-light" data-os-animation="data-os-animation">
    <div class="section-masthead__inner container-fluid">
      <header class="row section-masthead__header justify-content-start">
        <div class="col">
          <div class="subheading split-text js-split-text section-masthead__subheading" data-split-text-type="lines, words, chars" data-split-text-set="chars">
            {{ $photography->name }}
          </div>
          <h1 class="js-text-to-fly split-text js-split-text section-masthead__heading" data-split-text-type="lines, words, chars" data-split-text-set="chars">
            {{ $photography->cover_title }}
          </h1>
          <div class="split-text js-split-text section-masthead__text h6 title" data-split-text-type="lines" data-split-text-set="lines">
            {!! $photography->cover_paragraph !!}
          </div>
          <div class="section__headline"></div>
        </div>
      </header>
    </div>
  </section>
  <!-- - section MASTHEAD -->
  @if(!$pages->isEmpty())
  <!-- section IMAGE #1 -->
  <section class="section section-image section_w-container-center section_h-800">
    <div class="section-image__wrapper" data-art-parallax="background" data-art-parallax-factor="0.1">
      <div class="art-parallax__bg lazy-bg" data-src="{{ url('storage/'.$pages->first()->url) }}"></div>
    </div>
  </section>
  <!-- - section IMAGE #1 -->
  <section class="section section-masthead section_pt-small text-center bg-light" data-os-animation="data-os-animation">
    <div class="section-masthead__inner container-fluid">
      <div class="row section-masthead__header justify-content-start">
        <div class="col">
          <h2 class="js-text-to-fly split-text js-split-text section-masthead__heading" data-split-text-type="lines, words, chars" data-split-text-set="chars">
            {{ $photography->info_title }}
          </h2>
          <h3 class="heading-light split-text js-split-text section-masthead__text" data-split-text-type="lines" data-split-text-set="lines">
            {!! $photography->info_paragraph !!}
          </h3>
          <div class="section__headline"></div>
        </div>
      </div>
    </div>
  </section>
  <!-- section GRID #1 -->
  <section class="section section-grid section_pt section_pb bg-light">
    <div class="container">
      <div class="grid grid_fluid-6 js-grid">
        <div class="grid__item grid__item_desktop-6 grid__item_tablet-6 grid__item_mobile-12 grid__item_fluid-6 grid__item_fluid-6-fancy grid__sizer js-grid__sizer"></div>
        <div class="grid__item grid__item_desktop-6 grid__item_tablet-6 grid__item_mobile-12 grid__item_fluid-6 grid__item_fluid-6-fancy js-grid__item">
          <div class="figure-image section-image">
            <div class="lazy"><img data-src="{{ url('storage/'.$pages[1]->url) }}" src="#" alt="{{ $pages[1]->name }}" width="900" height="1350"/></div>
          </div>
        </div>
        <div class="grid__item grid__item_desktop-6 grid__item_tablet-6 grid__item_mobile-12 grid__item_fluid-6 grid__item_fluid-6-fancy js-grid__item">
          <div class="figure-image section-image">
            <div class="lazy"><img data-src="{{ url('storage/'.$pages->last()->url) }}" src="#" alt="{{ $pages->last()->name }}" width="900" height="1350"/></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- - section GRID #1 -->
  <!-- section IMAGE #2 -->
  <section class="section section-image section_w-container-center section_h-800">
    <div class="section-image__wrapper" data-art-parallax="background" data-art-parallax-factor="0.1">
      <div class="art-parallax__bg lazy-bg" data-src="{{ url('storage/'.$pages->last()->url) }}"></div>
    </div>
  </section>
  <!-- - section IMAGE #2 -->
  @else
  <div class="text-center pagination">
    <h2 class="figure-portfolio figure-portfolio-big">
      Gallery not Updated.
    </h2>
  </div>
  @endif
  </div>