<?php

declare(strict_types=1);

namespace App\Filament\Resources\Albums\Schemas;

use App\Services\MediaManager;
use App\Support\SlugGenerator;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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

                        FileUpload::make('gallery_uploads')
                            ->label('Fotografías')
                            ->multiple()
                            ->appendFiles()
                            ->panelLayout('grid')
                            ->image()
                            ->directory('media/albums')
                            ->disk('public')
                            ->columnSpanFull()
                            ->dehydrated(false)
                            ->maxSize(2048) // Límite de 2MB
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->loadStateFromRelationshipsUsing(fn (?Model $record, $component) => $record ? $component->state($record->media()->pluck('file_path')->toArray()) : null
                            )
                            ->saveRelationshipsUsing(fn (Model $record, $state) => app(MediaManager::class)->syncGallery($record, is_array($state) ? $state : [])
                            )
                            ->saveUploadedFileUsing(fn (TemporaryUploadedFile $file): string => app(MediaManager::class)->uploadAndOptimize($file, 'media/albums')
                            ),
                    ]),
            ]);
    }
}
