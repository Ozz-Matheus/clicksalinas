<?php

declare(strict_types=1);

namespace App\Models;

use App\Actions\PingSearchEnginesAction;
use App\Contracts\Indexable;
use App\Traits\IsPublished;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Album extends Model implements Indexable
{
    use IsPublished;

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
        static::saved(function (self $model) {
            app(PingSearchEnginesAction::class)->execute($model);
        });

        static::deleting(function (self $model) {
            $model->media->each->delete();
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

    public function scopeVisibleTo(Builder $query, User $user): void
    {
        if (! $user->hasRole('super_admin')) {
            $query->where('user_id', $user->id);
        }
    }

    public function getIndexableUrl(): string
    {
        return route('portfolio.album', $this->slug);
    }
}
