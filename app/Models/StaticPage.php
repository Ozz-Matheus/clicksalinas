<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class StaticPage extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'cover_title',
        'cover_paragraph',
        'info_title',
        'info_paragraph',
        'cover_image_path',
        'gallery',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
        ];
    }

    public function getUrlAttribute(): string
    {
        return $this->slug;
    }

    protected static function booted(): void
    {
        static::deleting(function (self $model) {
            // 1. Eliminar la imagen de portada si existe
            if (! empty($model->cover_image_path)) {
                Storage::disk('public')->delete($model->cover_image_path);
            }

            // 2. Eliminar todas las imágenes de la galería (Storage::delete acepta un array)
            if (! empty($model->gallery) && is_array($model->gallery)) {
                Storage::disk('public')->delete($model->gallery);
            }
        });
    }
}
