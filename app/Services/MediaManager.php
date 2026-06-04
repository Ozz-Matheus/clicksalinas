<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Throwable;

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

            // Verificamos explícitamente que la escritura en disco sea exitosa
            if (! Storage::disk('public')->put($filename, $image->toWebp(80)->toString())) {
                throw new \Exception('Fallo al escribir el archivo optimizado en el disco.');
            }

            return $filename;

        } catch (Throwable $e) {
            Log::error('Error optimizando imagen: '.$e->getMessage(), [
                'file' => $file->getClientOriginalName(),
                'directory' => $directory,
            ]);

            throw ValidationException::withMessages([
                'gallery_uploads' => "No se pudo procesar la imagen {$file->getClientOriginalName()}. Verifica el formato o intenta de nuevo.",
            ]);
        }
    }

    public function syncGallery(Model $record, array $state): void
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
