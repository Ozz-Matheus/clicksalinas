<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Throwable;

class ImageOptimizationService
{
    public function optimizeAndStore(TemporaryUploadedFile $file, string $directory): string
    {
        try {
            $manager = new ImageManager(new Driver);
            $image = $manager->read($file->getRealPath());
            $image->scaleDown(width: 1280);

            $safeName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $filename = "{$directory}/{$safeName}---".Str::random(8).'.webp';

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
}
