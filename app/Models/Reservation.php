<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Reservation extends Model
{
    // Aseguramos que todos los campos requeridos e introducidos estén aquí
    protected $fillable = [
        'uuid',
        'crm_task_id',
        'reference',
        'service_id',
        'name',
        'email',
        'amount',
        'status',
    ];

    /**
     * El método booted se ejecuta automáticamente en los eventos del ciclo de vida de Eloquent.
     */
    protected static function booted(): void
    {
        static::creating(function (self $model) {
            // Genera el UUID seguro de forma automática al crear el registro
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }

            // Genera la referencia única automáticamente si no viene definida
            if (empty($model->reference)) {
                $model->reference = 'RES-'.Str::upper(Str::random(10));
            }
        });
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
