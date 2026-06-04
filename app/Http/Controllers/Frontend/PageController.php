<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
        $page = StaticPage::where('slug', 'home')->firstOrFail();
        $cover = $page->cover_image_path ? 'storage/'.$page->cover_image_path : null;

        // 1. Cargamos todos los servicios requeridos y sus relaciones en solo 2 queries.
        $services = Service::query()
            ->whereIn('slug', ['weddings', 'photoshoot', 'commercials'])
            ->with(['latestPublishedAlbum.media'])
            ->get()
            ->keyBy('slug');

        // 2. Extraemos las variables evitando consultas adicionales a la BD.
        $weddingService = $services->get('weddings');
        $photoshootService = $services->get('photoshoot');
        $commercialService = $services->get('commercials');

        $featured_images = (object) [
            'weddingUrl' => $weddingService,
            'weddingLast' => $weddingService?->latestPublishedAlbum?->media->sortByDesc('name')->first(),

            'photoshootUrl' => $photoshootService,
            'photoshootLast' => $photoshootService?->latestPublishedAlbum?->media->sortByDesc('name')->first(),

            'commercialUrl' => $commercialService,
            'commercialLast' => $commercialService?->latestPublishedAlbum?->media->sortByDesc('name')->first(),
        ];

        return view('pages', compact('page', 'cover', 'featured_images'));
    }

    /**
     * Muestra la página de Acerca de (About)
     */
    public function about(): View
    {
        $page = StaticPage::where('slug', 'about')->firstOrFail();
        $cover = $page->cover_image_path ? Storage::url($page->cover_image_path) : null;

        return view('pages', compact('page', 'cover'));
    }
}
