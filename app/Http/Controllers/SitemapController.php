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
        $xml = cache()->remember('sitemap.xml', now()->addHours(12), function () {
            $services = Service::all();
            $albums = Album::published()->latest('published_at')->get();
            $posts = Post::published()->latest('published_at')->get();
            $vipSlugs = config('seo.vip_tags') ?? [];
            $highValueTags = Tag::whereIn('slug', $vipSlugs)->get()->unique('slug');

            return view('sitemap', compact('services', 'albums', 'posts', 'highValueTags'))->render();
        });

        return response($xml)->header('Content-Type', 'text/xml');
    }
}
