<?php

declare(strict_types=1);

namespace App\Actions;

use App\Contracts\Indexable;
use App\Jobs\PingIndexNowJob;
use Illuminate\Database\Eloquent\Model;

class PingSearchEnginesAction
{
    /**
     * Evalúa el modelo y notifica a los motores de búsqueda si es aplicable.
     */
    public function execute(Model $model): void
    {
        // 1. Salida temprana si el modelo no fue diseñado para ser indexado
        if (! $model instanceof Indexable) {
            return;
        }

        // 2. Condición de salida temprana: si no está publicado o no tiene slug
        if (! $model->published_at || $model->published_at > now() || empty($model->slug)) {
            return;
        }

        // 3. Despachamos el trabajo obteniendo la URL directamente del contrato
        dispatch(new PingIndexNowJob($model->getIndexableUrl()))->afterResponse();
    }
}
