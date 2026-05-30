<?php

declare(strict_types=1);

namespace App\Filament\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class MediaRelationManager extends RelationManager
{
    // Definimos la relación que está en los modelos Album y Post
    protected static string $relationship = 'media';

    protected static ?string $title = 'Administrador de Galería';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('file_path')
            ->columns([
                ImageColumn::make('file_path')
                    ->label('Fotografía')
                    ->disk('public')
                    ->circular()
                    ->imageSize(120),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->weight('bold')
                    ->searchable(),
            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Añadir Fotografía')
                    ->modalHeading('Subir imagen a esta galería')
                    ->schema([
                        FileUpload::make('file_path')
                            ->label('Selecciona la Imagen')
                            ->image()
                            ->required()
                            ->disk('public')
                            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file, $livewire): string {
                                $manager = new ImageManager(new Driver);
                                $image = $manager->read($file->getRealPath());
                                $image->scaleDown(width: 1280);

                                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                $safeName = Str::slug($originalName);

                                // Detectamos dinámicamente si viene de un Post o de un Album para guardarlo en su carpeta
                                $folder = str_contains(get_class($livewire->getOwnerRecord()), 'Post') ? 'posts' : 'albums';
                                $filename = "media/{$folder}/".$safeName.'---'.Str::random(8).'.webp';

                                Storage::disk('public')->put($filename, $image->toWebp(80)->toString());

                                return $filename;
                            }),
                    ]),
            ]);
    }
}
