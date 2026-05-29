<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- Rutas Estáticas --}}
    <url>
        <loc>{{ route('pages.home') }}</loc>
        <lastmod>2026-04-10T00:00:00Z</lastmod>
    </url>
    {{-- Pendientes de activar en web.php --}}
    {{-- <url>
        <loc>{{ route('pages.about') }}</loc>
    </url>
    <url>
        <loc>{{ route('pages.contact') }}</loc>
    </url> --}}

    {{-- Páginas de Categorías de Servicios --}}
    @foreach($services as $service)
        <url>
            <loc>{{ route('portfolio.service', $service->slug) }}</loc>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach

    {{-- Ciclo para Álbumes / Trabajos individuales --}}
    @foreach($albums as $album)
        <url>
            <loc>{{ route('portfolio.album', $album->slug) }}</loc>
            <lastmod>{{ $album->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        </url>
    @endforeach

    {{-- Ciclo para Posts (Blog) --}}
    @foreach($posts as $post)
        <url>
            <loc>{{ route('blog.show', $post->slug) }}</loc>
            <lastmod>{{ $post->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        </url>
    @endforeach

    {{-- Ciclo para Tags Estratégicos --}}
    @foreach($highValueTags as $tag)
        <url>
            <loc>{{ route('blog.tag', $tag->slug) }}</loc>
        </url>
    @endforeach

</urlset>