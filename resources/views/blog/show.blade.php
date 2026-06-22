{{-- resources/views/posts/show.blade.php --}}
@extends('layout')

@php
    // 1. Limpiamos el título
    $cleanTitle = html_entity_decode($post->title, ENT_QUOTES, 'UTF-8');

    // 2. Limpieza de la descripción/excerpt
    $rawDescription = strip_tags($post->excerpt ?? $post->body);
    $cleanDescription = html_entity_decode($rawDescription, ENT_QUOTES, 'UTF-8');
    $cleanDescription = preg_replace("/\r|\n/", " ", $cleanDescription);
    $cleanDescription = trim(preg_replace("/\s+/", " ", $cleanDescription));
    $cleanDescription = str_replace('&nbsp;', ' ', $cleanDescription);
@endphp

{{-- Media Tag Social --}}
@section('meta-title')
{!! $cleanTitle !!} : {{ config('app.name') }}
@endsection
@section('meta-image'){{ $post->media->count() > 0 ? url($post->media->first()->url) : '/images/clicksalinas-logotipo.jpg' }}@stop
@section('meta-type',  'article' )
@section('meta-description', $cleanDescription)
{{-- Media Tag Social --}}

@section('content')
          <!-- section MASTHEAD -->
          <section data-post-id="{{ $post->id }}" class="section section-masthead section_pt-large text-center" data-os-animation="data-os-animation">
            <div class="section-masthead__inner container">
              <header class="row section-masthead__header justify-content-center">
                <div class="col">
                  <div class="section-masthead__meta">
                    <div class="post-preview__meta post-preview__date">
                      <time datetime="{{ optional($post->published_at)->toDateString() }}">
                        {{ optional($post->published_at)->format('M d, Y') }}
                      </time>
                    </div>
                    @if($post->category)
                    <div class="post-preview__meta col-12">
                      <a href="{{ route('blog.category', $post->category) }}">
                        <span class="categories-show title h4">{{ $post->category->name }}</span>
                      </a>
                    </div>
                    @endif
                  </div>
                  <h1 class="js-text-to-fly split-text js-split-text section-masthead__heading" data-split-text-type="lines, words, chars" data-split-text-set="chars">{!! $cleanTitle !!}</h1>
                  <div class="section__headline"></div>
                </div>
              </header>
            </div>
          </section>
          <!-- - section MASTHEAD -->
          <div class="container-fluid container_xs-no-padding">
            <!-- section BLOG -->
            <section class="section section-blog section_mt-small bg-white section_pt-small section_pb">
              <div class="container">
                <div class="row justify-content-between">
                  <div class="col-lg-10 offset-lg-1">
                    <div class="section-blog__posts">
                      <div class="section-blog__wrapper-post">
                        <article class="post">
                          <div class="post__media">
                            @if($post->media->count() > 0)
                            @if($post->media->count() == 1 )

                            <img src="{{ url($post->media->first()->url) }}" alt="{{ $post->media->first()->name }}" />

                            @elseif($post->media->count() > 1 )

                              @include('blog.carousel')

                            @endif
                          @endif
                          </div>
                          <!-- - .post__media-->
                          <div class="post__content">
                            {!! $post->body !!}
                            
                            @if($post->youtube_id)
                              <div class="video-post">
                                <iframe
                                  style="aspect-ratio: 16/9; width: 100%;"
                                  src="https://www.youtube.com/embed/{{ $post->youtube_id }}"
                                  title="YouTube video player"
                                  frameborder="0"
                                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                  referrerpolicy="strict-origin-when-cross-origin"
                                  allowfullscreen>
                                </iframe>
                              </div>
                            @endif
                          </div>
                          <!-- - .post__content-->
                          <div class="text-center">
                            @include('partials.social-links', ['description' => $cleanTitle ])
                          </div>
                          <!-- - .post__social_links-->
                          <div class="post__tags">
                            <div class="">
                              <ul class="post-preview__categories">
                              @foreach($post->tags as $tag)
                                <li>
                                  <a  href="{{ route('blog.tag', $tag) }}">
                                    #{{ $tag->name }}
                                  </a>
                                </li>
                                @endforeach
                              </ul>
                            </div>
                          </div>
                          <div class="post__comments">
                            <div id="disqus_thread"></div>
                            @include('partials.disqus-script')
                          </div>
                          <!-- - .post__comments-->
                        </article>
                      </div>
                    </div>
                    <!-- - post-->
                  </div>

                </div>
              </div>
            </section>
            <!-- - section BLOG -->
          </div>
          @include('partials.footer')

@stop
@push('scripts')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BlogPosting",
  "@@id": "{{ url()->current() }}#article",
  "headline": "{!! $cleanTitle !!}",
  "description": "{!! $cleanDescription !!}",
  "url": "{{ url()->current() }}",
  "datePublished": "{{ optional($post->published_at)->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  "author": { "@@id": "https://clicksalinas.com/#photographer" },
  "publisher": { "@@id": "https://clicksalinas.com/#business" },
  "image": {
    "@@type": "ImageObject",
    "url": "{{ $post->media->count() > 0 ? url($post->media->first()->url) : asset('images/clicksalinas-logotipo.jpg') }}"
  },
  "inLanguage": "en-US",
  "isPartOf": { "@@id": "https://clicksalinas.com/#website" }
}
</script>
<script id="dsq-count-scr" src="//salinas.disqus.com/count.js" async></script>
@endpush