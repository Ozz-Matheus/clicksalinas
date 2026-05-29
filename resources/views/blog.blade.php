@extends('layout')

@php
    // 1. Definimos las variables por defecto (Para el Blog principal)
    $mainTitle = 'Blog';
    $metaTitle = 'Blog : ' . config('app.name');
    $metaDescription = 'Explore our experience and advice in wedding photography, conventions and conferences, group photoshoots, families and proposals. Professional photographers.';
    $metaRobots = 'index, follow'; // El blog principal SI se indexa siempre

    // 2. Unificamos: $term será $tag o $category, el que exista.
    $term = $tag ?? $category ?? null;

    if($term) {
        // Lógica dinámica para el Tag o Categoría
        $cleanName = ucwords(str_replace('-', ' ', $term->name));
        $mainTitle = $cleanName;
        $metaTitle = $cleanName . ' | Blog : ' . config('app.name');
        $metaDescription = 'Browse our blog to find stories, galleries, and expert advice about ' . strtolower($cleanName) . ' in Cartagena de Indias.';

        // 3. POR DEFECTO: Mandamos a NOINDEX cualquier etiqueta o categoría
        $metaRobots = 'noindex, follow';

        // 4. LA LISTA BLANCA (VIP): Solo estas se van a indexar en Google
        $highValueTerms = config('seo.vip_tags');

        // 5. Si el término actual está en la lista blanca, lo salvamos y lo indexamos
        if(in_array(strtolower($term->url), $highValueTerms)) {
            $metaRobots = 'index, follow';
        }
    }
@endphp

{{-- Inyectamos las variables al layout --}}
@section('meta-title', $metaTitle)
@section('meta-description', $metaDescription)
@section('meta-robots', $metaRobots)

{{-- Inyectamos las variables calculadas al layout --}}
@section('meta-title', $metaTitle)
@section('meta-description', $metaDescription)
@section('meta-robots', $metaRobots)

@section('content')
          <!-- section MASTHEAD -->
          <section class="section section-masthead section_pt-large text-center" data-os-animation="data-os-animation">
            <div id="{{ $term ? 'data-term-'.$term->id : 'blog' }}" class="section-masthead__inner container">
              <header class="row section-masthead__header justify-content-center">
                <div class="col">
                  <h1 class="js-text-to-fly split-text js-split-text section-masthead__heading" data-split-text-type="lines, words, chars" data-split-text-set="chars">
                    {{ $mainTitle }}
                  </h1>
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
                  <div class="col-lg-8 offset-lg-2">
                    <div class="section-blog__posts">
                    @forelse($posts as $post)
                      <div class="section-blog__wrapper-post">
                        <article class="post post-preview">
                          <div class="post-preview__media">
                            <a href="{{ route('blog.show', $post) }}">
                            @if($post->media->count() > 0)
                                <img src="{{ url($post->media->first()->url) }}" alt="{{ $post->media->first()->name }}">
                            @endif
                            </a>
                          </div>
                          <div class="post-preview__header">
                            <h4>
                                <a href="{{ route('blog.show', $post) }}">
                                    {{ $post->title }}
                                </a>
                            </h4>
                          </div>
                          <div class="row">
                            <div class="col-lg-4 post-preview__wrapper-meta">
                              <div class="post-preview__meta post-preview__date">
                                <span>{{ optional( $post->published_at )->format('M d')  }}</span>
                              </div>
                              @if($post->category)
                              <div class="post-preview__meta">
                                <a class="button button_icon button_accent"  href="{{ route('blog.category', $post->category) }}">
                                    <div class="button__label__small">
                                        <span>{{ $post->category->name }}</span>
                                    </div>
                                </a>
                              </div>
                              @endif
                            </div>
                            <div class="col-lg-8 post-preview__wrapper-content">
                              <p>
                                {{ $post->excerpt }}
                              </p>
                              <div class="post-preview__wrapper-readmore">
                                <a class="button button_icon button_accent" href="{{ route('blog.show', $post) }}">
                                  <div class="button__label">
                                    Read More
                                  </div>
                                  <div class="button__icon"><i class="material-icons">keyboard_arrow_right</i></div>
                                </a>
                              </div>
                            </div>
                            <div class="col-lg-8 post-preview__wrapper-content">
                                <div class="post-preview__meta">
                                    <ul class="post-preview__categories">
                                    @foreach($post->tags as $tag)
                                        <li>
                                            <a href="{{ route('blog.tag', $tag) }}">
                                                #{{ $tag->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                          </div>
                        </article>
                      </div>
                    @empty
                    <h1 class="figure-portfolio figure-portfolio-big text-center">
                      There are no posts yet.
                    </h1>
                    @endforelse
                    {{ $posts->appends(request()->all())->links() }}
                    </div>
                    <!-- - posts -->
                    <!-- - pagination -->
                  </div>
                </div>
              </div>
            </section>
            <!-- - section BLOG -->
          </div>
          @include('partials.footer')
@stop
