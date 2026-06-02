<?php

declare(strict_types=1);

namespace App\Filament\Resources\Posts\Schemas;

use App\Services\MediaManager;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(fn () => auth()->id()),

                Section::make('Información Principal')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título de la Publicación')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),

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
                            ->columnSpanFull(),

                        Textarea::make('iframe')
                            ->label('Código de inserción (YouTube/Vimeo)')
                            ->rows(3)
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

                        FileUpload::make('gallery_uploads')
                            ->label('Fotografías')
                            ->multiple()
                            ->appendFiles()
                            ->panelLayout('grid')
                            ->image()
                            ->directory('media/posts')
                            ->disk('public')
                            ->columnSpanFull()
                            ->dehydrated(false)
                            ->loadStateFromRelationshipsUsing(fn (?Model $record, $component) => $record ? $component->state($record->media()->pluck('file_path')->toArray()) : null
                            )
                            ->saveRelationshipsUsing(fn (Model $record, $state) => app(MediaManager::class)->syncGallery($record, is_array($state) ? $state : [])
                            )
                            ->saveUploadedFileUsing(fn (TemporaryUploadedFile $file): string => app(MediaManager::class)->uploadAndOptimize($file, 'media/posts')
                            ),
                    ]),
            ]);
    }
}
