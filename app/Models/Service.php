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
        'cover_title',
        'cover_paragraph',
        'info_title',
        'info_paragraph',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }
}
