<?php

namespace App\Filament\Resources\Albums\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AlbumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('body')
                    ->columnSpanFull(),
                DateTimePicker::make('published_at'),
                Select::make('service_id')
                    ->relationship('service', 'name'),
                TextInput::make('user_id')
                    ->numeric(),
            ]);
    }
}
