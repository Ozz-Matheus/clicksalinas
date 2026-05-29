<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Post;
use App\Models\Service;
use App\Models\Tag;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Genera el archivo XML del mapa del sitio
     */
    public function index(): Response
    {
        // 1. Páginas de Servicios (Money Pages)
        $services = Service::all();

        // 2. Álbumes o sesiones fotográficas individuales publicados
        $albums = Album::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->get();

        // 3. Artículos del Blog publicados
        $posts = Post::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->get();

        // 4. Etiquetas estratégicas de alto valor (VIP)
        $vipSlugs = config('seo.vip_tags') ?? [];
        $highValueTags = Tag::whereIn('slug', $vipSlugs)->get()->unique('slug');

        return response()->view('sitemap', compact('services', 'albums', 'posts', 'highValueTags'))
            ->header('Content-Type', 'text/xml');
    }
}
