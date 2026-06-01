<?php

declare(strict_types=1);

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\RichEditor;
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
                            ->label('Enlace')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('cover_title')->label('Título de Portada'),
                        RichEditor::make('cover_paragraph')->label('Párrafo de Portada'),
                    ]),

                Section::make('Información Adicional')
                    ->schema([
                        TextInput::make('info_title')->label('Título informativo'),
                        RichEditor::make('info_paragraph')->label('Párrafo informativo'),
                    ]),
            ]);
    }
}
