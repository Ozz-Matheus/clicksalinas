<?php

declare(strict_types=1);

namespace App\Contracts;

interface Indexable
{
    /**
     * Devuelve la URL pública y absoluta del modelo para ser indexada.
     */
    public function getIndexableUrl(): string;
}
