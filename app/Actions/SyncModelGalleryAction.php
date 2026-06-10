<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class SyncModelGalleryAction
{
    public function execute(Model $record, array $state, string $fieldName = 'gallery_uploads'): void
    {
        try {
            DB::transaction(function () use ($record, $state) {
                $mediaQuery = $record->media();

                // Prevenimos el error en SQL si el usuario borró todas las fotos
                if (! empty($state)) {
                    $mediaQuery->whereNotIn('file_path', $state);
                }

                $mediaToDelete = $mediaQuery->get();

                foreach ($mediaToDelete as $media) {
                    // Esto ahora es 100% seguro gracias al afterCommit en el modelo
                    $media->delete();
                }

                $existingPaths = $record->media()->pluck('file_path')->flip()->toArray();

                foreach ($state as $path) {
                    if (! isset($existingPaths[$path])) {
                        $record->media()->create(['file_path' => $path]);
                    }
                }
            });
        } catch (Throwable $e) {
            Log::error('Error sincronizando galería del modelo', [
                'record_id' => $record->id,
                'record_type' => get_class($record),
                'exception' => $e->getMessage(),
            ]);

            throw ValidationException::withMessages([
                $fieldName => ['Ocurrió un error al intentar actualizar la base de datos de la galería.'],
            ]);
        }
    }
}
