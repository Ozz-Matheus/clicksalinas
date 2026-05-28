<?php

declare(strict_types=1);

namespace App\Filament\Resources\Albums\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
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

class AlbumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Inyectamos el ID del usuario silenciosamente
                Hidden::make('user_id')
                    ->default(fn () => auth()->id()),

                Section::make('Detalles de la Sesión')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título del Álbum')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Select::make('service_id')
                            ->label('Servicio (Categoría)')
                            ->relationship('service', 'name')
                            ->required(),

                        DateTimePicker::make('published_at')
                            ->label('Fecha de Publicación')
                            ->default(now()),
                    ])->columns(2),

                Section::make('Descripción')
                    ->schema([
                        RichEditor::make('body')
                            ->label('Contenido del post')
                            ->columnSpanFull(),
                    ]),

                Section::make('Galería Fotográfica (Subida Múltiple)')
                    ->description('Arrastra todas las fotos a la vez. El sistema optimizará cada una a WebP y usará el nombre original como texto ALT para SEO.')
                    ->schema([
                        FileUpload::make('gallery_uploads') // Nombre virtual
                            ->label('Fotografías')
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->panelLayout('grid')
                            ->image()
                            ->directory('media/albums')
                            ->columnSpanFull()

                            // 1. Evitamos que Filament intente guardarlo en la tabla 'albums'
                            ->dehydrated(false)

                            // 2. Al editar, cargamos las fotos desde la base de datos al componente
                            ->formatStateUsing(function (?Model $record) {
                                return $record ? $record->media()->pluck('file_path')->toArray() : [];
                            })

                            // 3. Al guardar el álbum, sincronizamos todo con nuestra tabla polimórfica 'media'
                            ->saveRelationshipsUsing(function (Model $record, $state) {
                                $state = is_array($state) ? $state : [];

                                // A. Limpieza: Si quitaste una foto en el panel, la borramos del disco y de la BD
                                $mediaToDelete = $record->media()->whereNotIn('file_path', $state)->get();
                                foreach ($mediaToDelete as $media) {
                                    Storage::disk('public')->delete($media->file_path);
                                    $media->delete();
                                }

                                // B. Guardado: Registramos las fotos nuevas en la BD
                                $existingPaths = $record->media()->pluck('file_path')->toArray();
                                foreach ($state as $path) {
                                    if (! in_array($path, $existingPaths)) {
                                        $record->media()->create([
                                            'file_path' => $path,
                                        ]);
                                    }
                                }
                            })

                            // 4. El procesamiento físico con Intervention Image (se ejecuta al arrastrar la foto)
                            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {
                                $manager = new ImageManager(new Driver);
                                $image = $manager->read($file->getRealPath());

                                $image->scaleDown(width: 1280);

                                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                $safeName = Str::slug($originalName);

                                $filename = 'media/albums/'.$safeName.'---'.Str::random(8).'.webp';

                                Storage::disk('public')->put($filename, $image->toWebp(80)->toString());

                                return $filename;
                            }),
                    ]),
            ]);
    }
}
