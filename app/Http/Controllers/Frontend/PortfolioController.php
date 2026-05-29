<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Album;

class PortfolioController extends Controller
{
    // Laravel ya buscó el álbum por su slug en la BD. Si no existe, lanza un 404 automático.
    public function album(Album $album)
    {
        // Cargamos la relación polimórfica de fotos para evitar el problema de N+1 queries
        $album->load('media');

        return view('frontend.portfolio.album', compact('album'));
    }
}
