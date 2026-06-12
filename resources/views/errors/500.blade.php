@extends('layout')

{{-- Media Tag Social --}}
@section('meta-title',  '500  | '. config('app.name') )
@section('meta-robots', 'noindex, follow')
{{-- Media Tag Social --}}

@section('content')
          <!-- section 500 -->
          <section class="section section-fullheight section-500 text-center bg-ornament">
            <div class="section-fullheight__inner section-500__inner">
              <div class="container">
                <div class="row justify-content-center align-items-center">
                  <div class="col-lg-10">
                    <div class="section-500__header">
                      <h1 class="js">Oops... Looks like something went wrong.</h1>
                      <h4 class="heading-light">Please try again later. That's all we know.</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- - section 500 -->
@stop