<?php

declare(strict_types=1);

namespace App\Filament\Resources\StaticPages\Schemas;

use App\Support\SlugGenerator;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(SlugGenerator::update()),

                        TextInput::make('slug')
                            ->label('Enlace')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('cover_title')
                            ->label('Título de portada')
                            ->maxLength(255),

                        RichEditor::make('cover_paragraph')
                            ->label('Párrafo de portada')
                            ->columnSpanFull(),

                        FileUpload::make('cover_image_path')
                            ->label('Imagen de Portada')
                            ->image()
                            ->disk('public')
                            ->columnSpanFull()
                            ->deleteUploadedFileUsing(function (string $file) {
                                Storage::disk('public')->delete($file);
                            })
                            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {
                                $manager = new ImageManager(new Driver);
                                $image = $manager->read($file->getRealPath());
                                $image->scaleDown(width: 2000);

                                $filename = 'static_pages/covers/'.Str::random(40).'.webp';
                                Storage::disk('public')->put($filename, $image->toWebp(80)->toString());

                                return $filename;
                            }),
                    ]),

                Section::make('Información Adicional')
                    ->schema([
                        TextInput::make('info_title')
                            ->label('Título informativo')
                            ->maxLength(255),

                        RichEditor::make('info_paragraph')
                            ->label('Párrafo informativo')
                            ->columnSpanFull(),

                        FileUpload::make('gallery')
                            ->label('Galería')
                            ->multiple()
                            ->image()
                            ->appendFiles()
                            ->panelLayout('grid')
                            ->disk('public')
                            ->columnSpanFull()
                            ->deleteUploadedFileUsing(function (string $file) {
                                Storage::disk('public')->delete($file);
                            })
                            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {
                                $manager = new ImageManager(new Driver);
                                $image = $manager->read($file->getRealPath());
                                $image->scaleDown(width: 1280);

                                $filename = 'static_pages/galleries/'.Str::random(40).'.webp';
                                Storage::disk('public')->put($filename, $image->toWebp(80)->toString());

                                return $filename;
                            }),
                    ]),
            ]);
    }
}
