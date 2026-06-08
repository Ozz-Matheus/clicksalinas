<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait IsPublished
{
    /**
     * Scope para filtrar solo los registros que ya están publicados.
     */
    public function scopePublished(Builder $query): void
    {
        $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Verifica si la instancia actual es pública.
     */
    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at <= now();
    }
}
