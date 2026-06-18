<?php

declare(strict_types=1);

namespace App\Filament\Resources\Services\Schemas;

use App\Support\SlugGenerator;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

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
                            ->afterStateUpdated(SlugGenerator::update()),
                        TextInput::make('slug')
                            ->label('Enlace')
                            ->required()
                            ->unique(ignoreRecord: true),
                        RichEditor::make('description')->label('Descripción')
                            ->columnSpanFull(),
                    ])->columns(2),
                Section::make('Información Adicional')
                    ->schema([
                        TextInput::make('price')
                            ->label('Precio Total')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->prefix('$'),
                        TextInput::make('deposit_amount')
                            ->label('Anticipo')
                            ->maxValue(fn ($get) => $get('price'))
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->prefix('$'),
                    ])->columns(2),
            ]);
    }
}
