@extends('layout')

{{-- Media Tag Social --}}
@section('meta-title',  '404  | '. config('app.name') )
@section('meta-robots', 'noindex, follow')
{{-- Media Tag Social --}}

@section('content')
          <!-- section 404 -->
          <section class="section section-fullheight section-404 text-center bg-ornament">
            <div class="section-fullheight__inner section-404__inner">
              <div class="container">
                <div class="row justify-content-center align-items-center">
                  <div class="col-lg-10">
                    <div class="section-404__header">
                      <h1 class="js">That page can't be found</h1>
                      <h4 class="heading-light">It looks like nothing found at this location. Try to navigate the menu or go to the home page.</h4>
                    </div>
                    <div class="section-404__wrapper-button"><a class="button button_solid button_accent-primary-3" href="{{ route('pages.home') }}">Go to Homepage</a></div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- - section 404 -->
@stop