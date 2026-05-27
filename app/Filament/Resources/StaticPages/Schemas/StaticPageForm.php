<?php

declare(strict_types=1);

namespace App\Filament\Resources\StaticPages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class StaticPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información Principal')
                    ->description('Identificadores únicos de la página.')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ])->columns(2),

                Section::make('Sección de Portada')
                    ->description('Textos e imagen principal que aparecen al inicio de la página.')
                    ->schema([
                        TextInput::make('cover_title')
                            ->maxLength(255),
                        Textarea::make('cover_paragraph')
                            ->rows(3)
                            ->columnSpanFull(),

                        FileUpload::make('cover_image_path')
                            ->label('Imagen de Portada')
                            ->image()
                            ->columnSpanFull()
                            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {
                                // 1. Inicializar Intervention v3
                                $manager = new ImageManager(new Driver);
                                $image = $manager->read($file->getRealPath());

                                // 2. Redimensionar máx a 2000px (KISS: scaleDown ya incluye la regla upsize)
                                $image->scaleDown(width: 2000);

                                // 3. Generar nombre de archivo y ruta
                                $filename = 'static_pages/covers/'.Str::random(40).'.webp';

                                // 4. Codificar a WebP al 80% y guardar en el disco público
                                Storage::disk('public')->put($filename, $image->toWebp(80)->toString());

                                return $filename;
                            }),
                    ]),

                Section::make('Sección de Información')
                    ->description('Textos secundarios (ej. Misión, Visión, o textos extra).')
                    ->schema([
                        TextInput::make('info_title')
                            ->maxLength(255),
                        Textarea::make('info_paragraph')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Galería de Imágenes')
                    ->description('Sube múltiples imágenes. Puedes arrastrarlas para reordenarlas.')
                    ->schema([
                        FileUpload::make('gallery')
                            ->label('Galería')
                            ->multiple()
                            ->image()
                            ->reorderable()
                            ->appendFiles()
                            ->columnSpanFull()
                            // El closure se ejecuta por cada archivo individualmente
                            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {
                                $manager = new ImageManager(new Driver);
                                $image = $manager->read($file->getRealPath());

                                // Redimensionar a máx 1280px para las imágenes de galería
                                $image->scaleDown(width: 1280);

                                $filename = 'static_pages/galleries/'.Str::random(40).'.webp';

                                Storage::disk('public')->put($filename, $image->toWebp(80)->toString());

                                return $filename;
                            }),
                    ]),
            ]);
    }
}
