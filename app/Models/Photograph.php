<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Photograph extends Model
{
    protected $fillable = [
        'name',
        'cover_title',
        'cover_paragraph',
        'info_title',
        'info_paragraph',
        'url',
    ];

    public function getRouteKeyName(): string
    {
        return 'url';
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class, 'photography_id');
    }
}
