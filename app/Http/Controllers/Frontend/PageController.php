<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Service;
use App\Models\StaticPage;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Muestra la página principal (Home)
     */
    public function index(): View
    {
        // 1. La variable maestra que dirige page.blade.php
        $page = StaticPage::where('slug', 'home')->firstOrFail();

        $cover = $page->cover_image_path ? 'storage/'.$page->cover_image_path : null;

        // 2. Recreamos el objeto exacto
        $featured_images = (object) [
            'weddingUrl' => null,
            'weddingLast' => null,
            'photoshootUrl' => null,
            'photoshootLast' => null,
            'commercialUrl' => null,
            'commercialLast' => null,
        ];

        // --- Bodas ---
        $weddings = Service::where('slug', 'weddings')->first();
        if ($weddings) {
            $featured_images->weddingUrl = $weddings;

            $latestAlbum = Album::where('service_id', $weddings->id)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->latest('published_at')
                ->first();

            // Aplicamos tu regla exacta ->sortBy('name')->last() y la blindamos
            $featured_images->weddingLast = ($latestAlbum && $latestAlbum->media->isNotEmpty())
                ? $latestAlbum->media->sortBy('name')->last()
                : null;
        }

        // --- Photoshoot ---
        $photoshoot = Service::where('slug', 'photoshoot')->first();
        if ($photoshoot) {
            $featured_images->photoshootUrl = $photoshoot;

            $latestAlbum = Album::where('service_id', $photoshoot->id)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->latest('published_at')
                ->first();

            $featured_images->photoshootLast = ($latestAlbum && $latestAlbum->media->isNotEmpty())
                ? $latestAlbum->media->sortBy('name')->last()
                : null;
        }

        // --- Commercials ---
        $commercials = Service::where('slug', 'commercials')->first();
        if ($commercials) {
            $featured_images->commercialUrl = $commercials;

            $latestAlbum = Album::where('service_id', $commercials->id)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->latest('published_at')
                ->first();

            $featured_images->commercialLast = ($latestAlbum && $latestAlbum->media->isNotEmpty())
                ? $latestAlbum->media->sortBy('name')->last()
                : null;
        }

        return view('pages', compact('page', 'cover', 'featured_images'));
    }

    /**
     * Muestra la página de Acerca de (About)
     */
    public function about(): View
    {
        $page = StaticPage::where('slug', 'about')->firstOrFail();

        $cover = $page->cover_image_path
            ? Storage::url($page->cover_image_path)
            : null;

        return view('pages', compact('page', 'cover'));
    }
}
