<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('url')
                    ->url(),
                Textarea::make('excerpt')
                    ->columnSpanFull(),
                Textarea::make('iframe')
                    ->columnSpanFull(),
                Textarea::make('body')
                    ->columnSpanFull(),
                DateTimePicker::make('published_at'),
                Select::make('category_id')
                    ->relationship('category', 'name'),
                TextInput::make('user_id')
                    ->numeric(),
            ]);
    }
}
