<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- Rutas Estáticas --}}
    <url>
        <loc>{{ route('pages.home') }}</loc>
        {{-- Usar una fecha estática de tu último cambio grande de diseño/texto --}}
        <lastmod>2026-04-10T00:00:00Z</lastmod>
    </url>
    {{-- <url>
        <loc>{{ route('pages.about') }}</loc>
    </url>
    <url>
        <loc>{{ route('pages.contact') }}</loc>
    </url> --}}

    {{-- Páginas de Servicios (Money Pages) --}}
    {{-- @foreach($services as $service)
        <url>
            <loc>{{ route('photographs.show', $service->url) }}</loc>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach --}}

    {{-- Ciclo para Pages (Servicios) --}}
    {{-- @foreach($pages as $page)
        <url>
            <loc>{{ route('pages.show', $page) }}</loc>
            <lastmod>{{ $page->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        </url>
    @endforeach --}}

    {{-- Ciclo para Posts (Blog) --}}
    @foreach($posts as $post)
        <url>
            <loc>{{ route('blog.show', $post) }}</loc>
            <lastmod>{{ $post->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        </url>
    @endforeach

    {{-- Ciclo para Tags Estratégicos --}}
    @foreach($highValueTags as $tag)
        <url>
            <loc>{{ route('blog.tag', $tag) }}</loc>
        </url>
    @endforeach

</urlset>