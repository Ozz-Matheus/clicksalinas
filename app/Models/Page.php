<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    protected $fillable = [
        'title',
        'url',
        'body',
        'published_at',
        'photography_id',
        'user_id',
    ];

    public function getRouteKeyName(): string
    {
        return 'url';
    }

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function photograph(): BelongsTo
    {
        return $this->belongsTo(Photograph::class, 'photography_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
