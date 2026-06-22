<?php

declare(strict_types=1);

namespace App\Models;

use App\Actions\PingSearchEnginesAction;
use App\Contracts\Indexable;
use App\Traits\IsPublished;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model implements Indexable
{
    use IsPublished;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'iframe',
        'body',
        'published_at',
        'category_id',
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
        static::saved(function (self $model) {
            app(PingSearchEnginesAction::class)->execute($model);
        });

        static::deleting(function (self $model) {
            $model->media->each->delete();
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeVisibleTo(Builder $query, User $user): void
    {
        if (! $user->hasAnyRole(['super_admin', 'manager'])) {
            $query->where('user_id', $user->id);
        }
    }

    public function getIndexableUrl(): string
    {
        return route('blog.show', $this->slug);
    }

    /**
     * Extrae el ID del video de YouTube desde la URL guardada en el campo 'iframe'.
     */
    public function getYoutubeIdAttribute(): ?string
    {
        if (empty($this->iframe)) {
            return null;
        }

        // Esta expresión regular extrae el ID de 11 caracteres tanto de youtube.com como de youtu.be
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $this->iframe, $match);

        return $match[1] ?? null;
    }
}
