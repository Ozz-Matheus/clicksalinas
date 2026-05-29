{{-- resources/views/photographs/show.blade.php --}}
@extends('layout')

@php 
    // 1. Limpiamos el título (convierte &amp; en &)
    $cleanTitle = html_entity_decode($page->title, ENT_QUOTES, 'UTF-8');

    // 2. Súper limpieza de la descripción:
    // Quitamos etiquetas, convertimos entidades HTML, borramos saltos de línea y espacios dobles.
    $rawDescription = strip_tags($page->excerpt ?? $page->body);
    $cleanDescription = html_entity_decode($rawDescription, ENT_QUOTES, 'UTF-8');
    $cleanDescription = preg_replace("/\r|\n/", " ", $cleanDescription); // Adiós saltos de línea
    $cleanDescription = trim(preg_replace("/\s+/", " ", $cleanDescription)); // Adiós espacios dobles y &nbsp;
    $cleanDescription = str_replace('&nbsp;', ' ', $cleanDescription); // Por si se escapa alguno
@endphp

{{-- Media Tag Social --}}
@section('meta-title')
{!! $cleanTitle !!} : {{ config('app.name') }}
@endsection
@section('meta-image'){{ url($page->media->sortBy('name')->last()->url) }}@stop
@section('meta-type',  'article' )
{{-- Media Tag Social --}}

@section('json-ld')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "ImageGallery",
  "name": "{!! $cleanTitle !!}",
  "description": "{!! $cleanDescription !!}",
  "url": "{{ request()->url() }}",
  "publisher": {
    "@@id": "https://clicksalinas.com/#business"
  },
  "image": [
    @foreach($page->media->sortBy('name') as $image)
      "{{ url($image->url) }}"{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endsection

@section('content')
  <!-- section IMAGE -->
  <section class="section section-image section_h-800">
    <div class="section-image__wrapper" data-art-parallax="background" data-art-parallax-factor="0.09">
      <div class="art-parallax__bg lazy-bg" data-src="{{ url($page->media->sortBy('name')->last()->url) }}"></div>
    </div>
  </section>
  <!-- - section IMAGE -->
  <!-- section CONTENT #1 -->
  <section data-page-id="{{ $page->id }}" class="section section-content section_pt section_pb text-center bg-white" data-os-animation="data-os-animation">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10 section-content__header">
          <div class="split-text js-split-text" data-split-text-type="lines" data-split-text-set="lines">
            <h1 class="heading-light h4 title">{!! $cleanTitle !!}</h1>
          </div>
          <div class="page-preview__meta page-preview__date">
            <time datetime="{{ optional($page->created_at)->toDateString() }}">
              {{ optional($page->created_at)->format('M d, Y') }}
            </time>
          </div>
          <div class="section__headline"></div>
          {!! $page->body !!}
        </div>
        <div class="col-lg-10 section_pt-xsmall">
          @include('partials.social-links', ['description' => $cleanTitle ])
        </div>
      </div>
    </div>
  </section>
  <!-- - section CONTENT #1 -->
  @foreach($page->media->sortBy('name') as $image)
  <!-- section IMAGE -->
  <section class="section section-image container-fluid section_pb-xsmall bg-white text-center">
    <div class="section-image__wrapper">
      @if(!$loop->last)
      <div class="lazy">
        <img data-src="{{ url( $image->url ) }}"
        alt="{{ $image->name }}" />
      </div>
      @endif
    </div>
  </section>
  <!-- - section IMAGE -->
  @endforeach
  @include('partials.footer')
@stop
