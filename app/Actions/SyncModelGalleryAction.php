<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
            DB::transaction(function () use ($record, $state) {
                // 1. Identificar registros a eliminar
                $mediaToDelete = $record->media()->whereNotIn('file_path', $state)->get();

                // 2. Borrar de base de datos primero (la transacción nos protege)
                foreach ($mediaToDelete as $media) {
                    $media->delete();
                }

                // 3. Indexar estado actual para búsqueda O(1)
                $existingPaths = $record->media()->pluck('file_path')->flip()->toArray();

                // 4. Crear los nuevos registros
                foreach ($state as $path) {
                    if (! isset($existingPaths[$path])) {
                        $record->media()->create(['file_path' => $path]);
                    }
                }

                // 5. Si la transacción en BD tuvo éxito, borramos los archivos físicos
                foreach ($mediaToDelete as $media) {
                    if (Str::startsWith($media->file_path, 'media/') && Storage::disk('public')->exists($media->file_path)) {
                        Storage::disk('public')->delete($media->file_path);
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
                'gallery_uploads' => 'Ocurrió un error al intentar actualizar la base de datos de la galería.',
            ]);
        }
    }
}
