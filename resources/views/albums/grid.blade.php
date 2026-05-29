          <!-- section MASTHEAD -->
          <section class="section section-masthead section_pt-large text-center" data-os-animation="data-os-animation">
            <div class="section-masthead__inner container">
              <header class="row section-masthead__header justify-content-center">
                <div class="col">
                  @if($page->name)
                  <h1 class="js-text-to-fly split-text js-split-text section-masthead__heading" data-split-text-type="lines, words, chars" data-split-text-set="chars">
                    {{ $page->name }}
                  </h1>
                  {!! $page->cover_paragraph !!}
                  @endif
                  <div class="section__headline"></div>
                </div>
              </header>
            </div>
          </section>
          <!-- - section MASTHEAD -->
          <!-- section PORTFOLIO -->
          <section class="section section-portfolio bg-white section_mt-small section_pb-small">
            <div class="section-portfolio__wrapper-grid">
              <div class="container-fluid">
                <div class="{{  count($albums) < 6 ? 'section_pt section_pb-xsmall' : 'grid grid_fluid-3 js-grid'  }}">
                  @forelse($albums as $album)
                  <div class="grid__item grid__item_desktop-6 grid__item_tablet-6 grid__item_mobile-12 grid__item_fluid-3 js-grid__item house-interior"><a class="figure-portfolio figure-portfolio-item_hover" href="{{ url('/photography', $album) }}" data-pjax-link="flyingHeading">
                      <div class="figure-portfolio__wrapper-img">
                        <div class="lazy">
                          <img data-src="{{ url($album->media->sortBy('name')->first()->url) }}" src="#" alt="" width="960" height="960"/>
                        </div>
                        <div class="figure-portfolio__content bg-accent-primary-2">
                          <div class="figure-portfolio__category">{{ $album->service->name }}</div>
                          <div class="figure-portfolio__header">
                            <h4 class="figure-portfolio__heading split-text js-text-to-fly js-split-text" data-split-text-type="lines, words, chars" data-split-text-set="chars">{{ $album->title }}</h4>
                            <div class="figure-portfolio__icon material-icons">keyboard_arrow_right</div>
                          </div>
                          <div class="figure-portfolio__curtain bg-accent-primary-2"></div>
                        </div>
                      </div></a>
                  </div>
                  @empty
                  <h1 class="figure-portfolio figure-portfolio-big text-center">
                    Gallery not Updated.
                  </h1>
                  @endforelse
                </div>
              </div>
            </div>
          </section>
          <!-- - section PORTFOLIO -->
