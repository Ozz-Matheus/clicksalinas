<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Media;
use App\Models\Service;
use App\Models\StaticPage;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Muestra la página principal (Home)
     */
    public function index(): View
    {
        // 1. La variable maestra que dirige page.blade.php
        $page = StaticPage::where('slug', 'home')->firstOrFail();

        $cover = $page->cover_image_path ? 'storage/'.$page->cover_image_path : null;

        // 2. Recreamos el objeto exacto que armaba tu viejo getHomeImages()
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
            $featured_images->weddingLast = Media::whereHasMorph('mediable', Album::class, fn ($q) => $q->where('service_id', $weddings->id))->latest('id')->first();
        }

        // --- Photoshoot ---
        $photoshoot = Service::where('slug', 'photoshoot')->first();
        if ($photoshoot) {
            $featured_images->photoshootUrl = $photoshoot;
            $featured_images->photoshootLast = Media::whereHasMorph('mediable', Album::class, fn ($q) => $q->where('service_id', $photoshoot->id))->latest('id')->first();
        }

        // --- Commercials ---
        $commercials = Service::where('slug', 'commercials')->first();
        if ($commercials) {
            $featured_images->commercialUrl = $commercials;
            $featured_images->commercialLast = Media::whereHasMorph('mediable', Album::class, fn ($q) => $q->where('service_id', $commercials->id))->latest('id')->first();
        }

        return view('pages', compact('page', 'cover', 'featured_images'));
    }
}
