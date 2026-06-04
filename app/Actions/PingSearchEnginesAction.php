<?php

declare(strict_types=1);

namespace App\Actions;

use App\Jobs\PingIndexNowJob;
use App\Models\Album;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

class PingSearchEnginesAction
{
    /**
     * Evalúa el modelo y notifica a los motores de búsqueda si es aplicable.
     */
    public function execute(Model $model): void
    {
        // 1. Condición de salida temprana: si no está publicado o no tiene slug, abortamos.
        if (! $model->published_at || $model->published_at > now() || empty($model->slug)) {
            return;
        }

        // 2. Determinamos la URL de forma limpia
        $url = match (true) {
            $model instanceof Post => route('blog.show', $model->slug),
            $model instanceof Album => route('portfolio.album', $model->slug),
            default => null,
        };

        // 3. Despachamos el trabajo si obtuvimos una URL válida
        if ($url) {
            dispatch(new PingIndexNowJob($url))->afterResponse();
        }
    }
}
