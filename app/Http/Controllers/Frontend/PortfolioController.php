<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Service;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    /**
     * Muestra la cuadrícula (grid) de álbumes para un servicio específico (Ej. Bodas)
     * Ruta: /photographs/{service:slug}
     */
    public function service(Service $service): View
    {
        // 1. Tu vista pages.blade.php espera una variable maestra llamada $page para el SEO
        // Como los servicios tienen 'name', 'slug', 'cover_paragraph', etc., encaja perfecto.
        $page = $service;

        // 2. La vista espera una variable $pages para iterar en el grid y mostrar la paginación.
        // Usamos Eager Loading (with('media')) para evitar lentitud al cargar las portadas.
        $albums = $service->albums()
            ->with('media')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(12); // Puedes ajustar cuántos álbumes salen por página

        // 3. Fallback de imagen para el SEO de la categoría
        // (Si no tienes columna cover_image_path en services, puedes dejarlo como null o poner una genérica)
        $cover = $service->cover_image_path ? 'storage/'.$service->cover_image_path : null;

        // Renderizamos tu layout maestro
        return view('pages', compact('page', 'cover', 'albums'));
    }

    /**
     * Muestra la galería individual de fotos de un álbum (Ej. laura-julian)
     * Ruta: /photography/{album:slug}
     */
    public function album(Album $album): View
    {
        // 1. Recreamos tu lógica de 2018: Solo se ve si está publicado O si eres el admin logueado
        $isPublished = $album->published_at && $album->published_at <= now();
        abort_if(! $isPublished && ! auth()->check(), 404);

        // 2. Cargamos las fotos asociadas para no saturar la base de datos
        $album->load('media');

        // 3. En 2018, tu vista photographs.show esperaba que la variable se llamara $page.
        // Se la inyectamos con ese nombre para no tener que tocar ni una línea de tu HTML.
        return view('albums.show', [
            'page' => $album,
        ]);
    }
}
