@extends('layout')

{{-- Media Tag Social --}}
@section('meta-title',  '403  | '. config('app.name') )
@section('meta-robots', 'noindex, follow')
{{-- Media Tag Social --}}

@section('content')
          <!-- section 403 -->
          <section class="section section-fullheight section-403 text-center bg-ornament">
            <div class="section-fullheight__inner section-403__inner">
              <div class="container">
                <div class="row justify-content-center align-items-center">
                  <div class="col-lg-10">
                    <div class="section-403__header">
                      <h1 class="js">Unauthorized access to this page</h1>
                      <h4 class="heading-light">It seems that you are not authorized. Try to navigate through the menu or go to the home page.</h4>
                    </div>
                    <div class="section-403__wrapper-button"><a class="button button_solid button_accent-primary-3" href="{{ url()->previous() }}">Go to back</a></div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- - section 403 -->
@stop