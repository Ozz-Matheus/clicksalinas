<?php

declare(strict_types=1);

namespace App\Filament\Resources\Posts\Schemas;

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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
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
                            ->label('Título del Post')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),

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

                        DateTimePicker::make('published_at')
                            ->label('Fecha de Publicación')
                            ->default(now()),
                    ])->columns(2),

                Section::make('Contenido')
                    ->schema([
                        Textarea::make('excerpt')
                            ->label('Extracto (Resumen corto)')
                            ->rows(3)
                            ->columnSpanFull(),

                        RichEditor::make('body')
                            ->label('Cuerpo del Post')
                            ->columnSpanFull(),

                        Textarea::make('iframe')
                            ->label('Código de inserción (YouTube/Vimeo)')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Galería del Artículo (Optimizada)')
                    ->description('Sube las fotos que acompañarán al post. Se optimizan a WebP y extraen el Alt de forma automática.')
                    ->schema([
                        FileUpload::make('gallery_uploads')
                            ->label('Fotografías')
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->panelLayout('grid')
                            ->image()
                            ->directory('media/posts') // <-- Carpeta dedicada al blog
                            ->columnSpanFull()
                            ->dehydrated(false)
                            ->formatStateUsing(function (?Model $record) {
                                return $record ? $record->media()->pluck('file_path')->toArray() : [];
                            })
                            ->saveRelationshipsUsing(function (Model $record, $state) {
                                $state = is_array($state) ? $state : [];

                                $mediaToDelete = $record->media()->whereNotIn('file_path', $state)->get();
                                foreach ($mediaToDelete as $media) {
                                    Storage::disk('public')->delete($media->file_path);
                                    $media->delete();
                                }

                                $existingPaths = $record->media()->pluck('file_path')->toArray();
                                foreach ($state as $path) {
                                    if (! in_array($path, $existingPaths)) {
                                        $record->media()->create([
                                            'file_path' => $path,
                                        ]);
                                    }
                                }
                            })
                            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {
                                $manager = new ImageManager(new Driver);
                                $image = $manager->read($file->getRealPath());

                                $image->scaleDown(width: 1280);

                                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                $safeName = Str::slug($originalName);

                                $filename = 'media/posts/'.$safeName.'---'.Str::random(8).'.webp';

                                Storage::disk('public')->put($filename, $image->toWebp(80)->toString());

                                return $filename;
                            }),
                    ]),
            ]);
    }
}
