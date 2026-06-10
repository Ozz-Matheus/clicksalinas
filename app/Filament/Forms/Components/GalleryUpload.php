<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use App\Actions\SyncModelGalleryAction;
use App\Services\ImageOptimizationService;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Model;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class GalleryUpload
{
    public static function make(string $name, string $directory): FileUpload
    {
        return FileUpload::make($name)
            ->label('Fotografías')
            ->multiple()
            ->appendFiles()
            ->panelLayout('grid')
            ->image()
            ->directory($directory)
            ->disk('public')
            ->visibility('public')
            ->columnSpanFull()
            ->dehydrated(false)
            ->maxSize(2048)
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->loadStateFromRelationshipsUsing(
                fn (?Model $record, $component) => $record ? $component->state($record->media()->pluck('file_path')->toArray()) : null
            )
            ->saveRelationshipsUsing(
                fn (Model $record, $state, SyncModelGalleryAction $action) => $action->execute($record, is_array($state) ? $state : [], $name)
            )
            ->saveUploadedFileUsing(
                fn (TemporaryUploadedFile $file, ImageOptimizationService $optimizer): string => $optimizer->optimizeAndStore($file, $directory, $name)
            );
    }
}
