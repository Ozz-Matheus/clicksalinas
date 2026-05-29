@extends('layout')

{{-- Lógica y Meta Tags Condicionales --}}
@if($page->url == 'home')
    @php
        // Calculamos la URL aquí para que esté disponible en el include de home
        $main_image = $featured_images->photoshootLast ? asset($featured_images->photoshootLast->url) : asset('/multimedia/demo/image-2.jpg');
    @endphp

@push('preload')
<link rel="preload" as="image" href="{{ $main_image }}" fetchpriority="high">
@endpush

@else
    {{-- Media Tag Social para las demás páginas (tu código original) --}}
    @section('meta-title',  $page->name .' : '. config('app.name') )
    @section('meta-image'){{ $cover ? url($cover) : '/multimedia/contact/cover-contact.jpg' }}@stop
    @section('meta-description'){!! strip_tags($page->cover_paragraph) !!}@stop
@endif

@section('content')
    <section>
        @if($page->url == 'home')
            @include('page.home')
        @elseif($page->url == 'about')
            @include('page.about')
        @elseif($page->url == 'contact')
            @include('page.contact')
        @else
            @include('albums.grid')
            <div class="section_pt-xsmall section_pb-xsmall">
                {{ $albums->appends(request()->all())->links() }}
            </div>
        @endif

        @unless($page->url == 'home')
            @include('partials.footer')
        @endunless
    </section>
@stop