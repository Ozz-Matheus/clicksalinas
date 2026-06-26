<?php

declare(strict_types=1);

namespace App\Filament\Resources\Posts\Schemas;

use App\Filament\Forms\Components\GalleryUpload;
use App\Support\SlugGenerator;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Información Principal')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título de la Publicación')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(SlugGenerator::update()),

                        TextInput::make('slug')
                            ->label('Enlace')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Textarea::make('excerpt')
                            ->label('Extracto (Resumen corto)')
                            ->rows(3)
                            ->columnSpanFull(),

                        RichEditor::make('body')
                            ->label('Contenido de la publicación')
                            ->extraAttributes([
                                'style' => 'min-height: 266px; max-height: 350px; overflow-y: auto;',
                            ])
                            ->columnSpanFull(),

                        TextInput::make('iframe')
                            ->label('Enlace de Youtube')
                            ->url()
                            ->columnSpanFull(),

                    ])->columns(2),

                Section::make('Información Adicional')
                    ->schema([

                        DateTimePicker::make('published_at')
                            ->label('Fecha de Publicación')
                            ->default(now()),

                        Select::make('category_id')
                            ->label('Categoría')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('tags')
                            ->label('Etiquetas')
                            ->multiple()
                            ->relationship('tags', 'name')
                            ->searchable()
                            ->preload(),

                        GalleryUpload::make('gallery_uploads', 'media/posts'),
                    ]),
            ]);
    }
}
