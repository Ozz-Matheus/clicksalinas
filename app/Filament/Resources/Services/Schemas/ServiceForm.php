<?php

declare(strict_types=1);

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identificación del Servicio')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre del Servicio')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                    ])->columns(2),

                Section::make('Textos de Portada')
                    ->schema([
                        TextInput::make('cover_title')->label('Título de Portada'),
                        Textarea::make('cover_paragraph')->label('Párrafo de Portada')->rows(3),
                    ])->columns(2),

                Section::make('Textos de Información')
                    ->schema([
                        TextInput::make('info_title')->label('Título de Información'),
                        Textarea::make('info_paragraph')->label('Párrafo de Información')->rows(3),
                    ])->columns(2),
            ]);
    }
}
