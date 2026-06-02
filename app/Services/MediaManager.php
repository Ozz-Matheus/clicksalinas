<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class MediaManager
{
    public function uploadAndOptimize(TemporaryUploadedFile $file, string $directory): string
    {
        try {
            $manager = new ImageManager(new Driver);
            $image = $manager->read($file->getRealPath());
            $image->scaleDown(width: 1280);

            $safeName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $filename = "{$directory}/{$safeName}---".Str::random(8).'.webp';

            Storage::disk('public')->put($filename, $image->toWebp(80)->toString());

            return $filename;
        } catch (\Throwable $e) {
            report($e);
            throw ValidationException::withMessages([
                'gallery_uploads' => 'Ocurrió un error al procesar la imagen.',
            ]);
        }
    }

    public function syncGallery(Model $record, array $state): void
    {
        // 1. Borrar lo que ya no está en el estado (Validando que exista)
        $mediaToDelete = $record->media()->whereNotIn('file_path', $state)->get();
        foreach ($mediaToDelete as $media) {
            if (Str::startsWith($media->file_path, 'media/') && Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }
            $media->delete();
        }

        // 2. Insertar los nuevos
        $existingPaths = $record->media()->pluck('file_path')->toArray();
        foreach ($state as $path) {
            if (! in_array($path, $existingPaths)) {
                $record->media()->create(['file_path' => $path]);
            }
        }
    }
}
