<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\IndexNowService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Album extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'body',
        'published_at',
        'service_id',
        'user_id',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        // Avisar a los buscadores cuando se publica/actualiza un álbum
        static::saved(function (Album $album) {

            $isPublished = $album->published_at && $album->published_at <= now();

            if ($isPublished && ! empty($album->slug)) {
                // Usamos la ruta oficial de tu web.php para el álbum
                $url = route('portfolio.album', $album->slug);
                app(IndexNowService::class)->submit($url);
            }
        });
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
