<?php

declare(strict_types=1);

namespace App\Filament\Resources\Albums\Schemas;

use App\Filament\Forms\Components\GalleryUpload;
use App\Support\SlugGenerator;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AlbumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Detalles de la Sesión')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título del Álbum')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(SlugGenerator::update()),

                        TextInput::make('slug')
                            ->label('Enlace')
                            ->required()
                            ->unique(ignoreRecord: true),

                        RichEditor::make('body')
                            ->label('Contenido del álbum')
                            ->extraAttributes([
                                'style' => 'min-height: 266px; max-height: 350px; overflow-y: auto;',
                            ])
                            ->columnSpanFull(),

                    ])->columns(2),

                Section::make('Información Adicional')
                    ->schema([

                        Select::make('service_id')
                            ->label('Servicio')
                            ->relationship('service', 'name')
                            ->required(),

                        DateTimePicker::make('published_at')
                            ->label('Fecha de Publicación')
                            ->default(now()),

                        GalleryUpload::make('gallery_uploads', 'media/albums'),
                    ]),
            ]);
    }
}
