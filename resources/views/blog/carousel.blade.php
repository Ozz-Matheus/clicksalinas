          <!-- section SLIDER #1 -->
          <section class="section section-slider section-offset section_pt-small section_pb-small section-offset_top">
            <div class="section-offset__content">
              <div class="swiper-container slider slider-images js-slider-images slider-images_footer-bottom" data-autoplay-enabled="true" data-centered-slides="true">
                <div class="swiper-wrapper">
                @foreach($post->media as $photo)
                  <div class="swiper-slide slider__slide">
                    <div class="slider__slide-inner"><img class="swiper-lazy" data-src="{{ url( $photo->url ) }}" src="#" alt=""/></div>
                  </div>
                @endforeach
                </div>
                <div class="container-fluid slider-images__footer">
                  <div class="row align-items-center justify-content-between">
                    <div class="col-auto col-md-4 text-left slider__footer-col order-md-1 order-1">
                      <div class="slider__arrows">
                        <div class="slider__arrow js-slider-images__prev"><i class="material-icons">keyboard_arrow_left</i></div>
                        <div class="slider__arrows-divider"></div>
                        <div class="slider__arrow js-slider-images__next"><i class="material-icons">keyboard_arrow_right</i></div>
                      </div>
                    </div>
                    <!-- - slider nav arrows -->
                    <div class="col-auto col-md-4 text-center slider__footer-col d-none d-md-block order-md-3 order-2">
                      <div class="slider__dots js-slider-images__dots">
                        <div class="slider__dot slider__dot_active">
                          <svg viewBox="0 0 152 152" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g fill="none" fill-rule="evenodd">
                              <g transform="translate(-134.000000, -98.000000)">
                                <path class="circle" d="M135,174a75,75 0 1,0 150,0a75,75 0 1,0 -150,0"></path>
                              </g>
                            </g>
                          </svg>
                        </div>
                        <div class="slider__dot">
                          <svg viewBox="0 0 152 152" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g fill="none" fill-rule="evenodd">
                              <g transform="translate(-134.000000, -98.000000)">
                                <path class="circle" d="M135,174a75,75 0 1,0 150,0a75,75 0 1,0 -150,0"></path>
                              </g>
                            </g>
                          </svg>
                        </div>
                        <div class="slider__dot">
                          <svg viewBox="0 0 152 152" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g fill="none" fill-rule="evenodd">
                              <g transform="translate(-134.000000, -98.000000)">
                                <path class="circle" d="M135,174a75,75 0 1,0 150,0a75,75 0 1,0 -150,0"></path>
                              </g>
                            </g>
                          </svg>
                        </div>
                        <div class="slider__dot">
                          <svg viewBox="0 0 152 152" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g fill="none" fill-rule="evenodd">
                              <g transform="translate(-134.000000, -98.000000)">
                                <path class="circle" d="M135,174a75,75 0 1,0 150,0a75,75 0 1,0 -150,0"></path>
                              </g>
                            </g>
                          </svg>
                        </div>
                      </div>
                    </div>
                    <!-- - slider nav dots -->
                    <div class="col-auto col-md-4 text-right slider-images__footer-col order-md-3 order-2">
                      <div class="slider__progress">
                        <div class="swiper-container slider__counter slider__counter_current js-slider-images__counter-current">
                          <div class="swiper-wrapper"></div>
                        </div>
                        <div class="slider__counter-divider"></div>
                        <div class="slider__counter slider__counter_total js-slider-images__counter-total">001</div>
                      </div>
                    </div>
                    <!-- - slider counter -->
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- - section SLIDER #1 -->