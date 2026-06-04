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

        $featured_images = (object) [
            'weddingUrl' => Service::where('slug', 'weddings')->first(),
            'weddingLast' => $this->getLatestMediaFor('weddings'),
            'photoshootUrl' => Service::where('slug', 'photoshoot')->first(),
            'photoshootLast' => $this->getLatestMediaFor('photoshoot'),
            'commercialUrl' => Service::where('slug', 'commercials')->first(),
            'commercialLast' => $this->getLatestMediaFor('commercials'),
        ];

        return view('pages', compact('page', 'cover', 'featured_images'));
    }

    /**
     * Obtiene los últimos medios para un servicio específico
     */
    private function getLatestMediaFor(string $serviceSlug)
    {
        $service = Service::where('slug', $serviceSlug)->first();
        if (! $service) {
            return null;
        }

        $latestAlbum = $service->albums()
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->first();

        if (! $latestAlbum) {
            return null;
        }

        return $latestAlbum->media()->orderBy('name', 'desc')->first();
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
