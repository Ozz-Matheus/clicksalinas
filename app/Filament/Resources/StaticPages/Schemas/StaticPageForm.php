<?php

namespace App\Filament\Resources\StaticPages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StaticPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('cover_title'),
                Textarea::make('cover_paragraph')
                    ->columnSpanFull(),
                TextInput::make('info_title'),
                Textarea::make('info_paragraph')
                    ->columnSpanFull(),
                FileUpload::make('cover_image_path')
                    ->image(),
                TextInput::make('gallery'),
            ]);
    }
}
