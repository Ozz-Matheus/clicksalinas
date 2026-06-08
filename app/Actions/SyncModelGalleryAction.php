<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class SyncModelGalleryAction
{
    public function execute(Model $record, array $state): void
    {
        try {
            $mediaToDelete = $record->media()->whereNotIn('file_path', $state)->get();

            foreach ($mediaToDelete as $media) {
                if (Str::startsWith($media->file_path, 'media/') && Storage::disk('public')->exists($media->file_path)) {
                    Storage::disk('public')->delete($media->file_path);
                }
                $media->delete();
            }

            $existingPaths = $record->media()->pluck('file_path')->toArray();

            foreach ($state as $path) {
                if (! in_array($path, $existingPaths)) {
                    $record->media()->create(['file_path' => $path]);
                }
            }
        } catch (Throwable $e) {
            Log::error("Error sincronizando galería del modelo {$record->id}: ".$e->getMessage());
            throw ValidationException::withMessages([
                'gallery_uploads' => 'Ocurrió un error al intentar actualizar la base de datos de la galería.',
            ]);
        }
    }
}
