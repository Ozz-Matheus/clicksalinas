<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    public function getUrlAttribute(): string
    {
        return $this->slug;
    }

    /**
     * Obtiene el último álbum publicado para este servicio.
     */
    public function latestPublishedAlbum()
    {
        return $this->hasOne(Album::class)
            ->published()
            ->latestOfMany('published_at');
    }
}
