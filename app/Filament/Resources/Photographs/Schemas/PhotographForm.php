<?php

namespace App\Filament\Resources\Photographs\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PhotographForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('cover_title'),
                Textarea::make('cover_paragraph')
                    ->columnSpanFull(),
                TextInput::make('info_title'),
                Textarea::make('info_paragraph')
                    ->columnSpanFull(),
                TextInput::make('url')
                    ->url()
                    ->required(),
            ]);
    }
}
