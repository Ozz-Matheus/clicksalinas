<?php

declare(strict_types=1);

namespace App\Models;

use App\Jobs\PingIndexNowJob;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
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
            if ($model->published_at && $model->published_at <= now() && ! empty($model->slug)) {
                $url = $model instanceof Post
                    ? route('blog.show', $model->slug)
                    : route('portfolio.album', $model->slug);

                dispatch(new PingIndexNowJob($url));
            }
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
        if (! $user->hasRole('super_admin')) {
            $query->where('user_id', $user->id);
        }
    }
}
