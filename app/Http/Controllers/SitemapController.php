<?php

namespace App\Http\Controllers;

// use App\Page;
// use App\Photography;
use App\Models\Post;
use App\Models\Tag;

class SitemapController extends Controller
{
    public function index()
    {
        // $pages = Page::published()->get();
        $posts = Post::all();

        // $services = Photography::all();

        $vipSlugs = config('seo.vip_tags');
        $highValueTags = Tag::whereIn('slug', $vipSlugs)->get()->unique('slug');

        return response()->view('sitemap', [
            // 'pages' => $pages,
            'posts' => $posts,
            // 'services' => $services,
            'highValueTags' => $highValueTags,
        ])->header('Content-Type', 'text/xml');
    }
}
