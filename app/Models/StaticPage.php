<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
