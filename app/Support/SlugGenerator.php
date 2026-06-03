<?php

declare(strict_types=1);

namespace App\Support;

use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

final class SlugGenerator
{
    public static function from(?string $value): string
    {
        return Str::slug($value ?? '');
    }

    /**
     * Helper directo para Filament: ->afterStateUpdated(SlugGenerator::update())
     */
    public static function update(): \Closure
    {
        return fn (Set $set, ?string $state) => $set('slug', self::from($state));
    }
}
