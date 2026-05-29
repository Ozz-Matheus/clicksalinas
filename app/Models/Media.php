<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Media extends Model
{
    protected $fillable = [
        'name',
        'file_path',
    ];

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    // Interceptamos la creación en BD para auto-llenar el SEO
    protected static function booted(): void
    {
        static::creating(function (Media $media) {
            // Si no tiene nombre (Alt Text), lo extraemos del nombre temporal que armamos en Filament
            if (empty($media->name) && $media->file_path) {
                $base = basename($media->file_path); // ej: "boda-en-playa---xyz123.webp"

                if (str_contains($base, '---')) {
                    $slugName = explode('---', $base)[0];
                    // Transforma "boda-en-playa" a "Boda En Playa"
                    $media->name = Str::title(str_replace('-', ' ', $slugName));
                } else {
                    $media->name = 'Fotografía del álbum';
                }
            }
        });
    }

    public function getUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    public function getAltAttribute(): ?string
    {
        return $this->name;
    }
}
