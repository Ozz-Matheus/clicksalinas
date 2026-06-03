<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Resources\Pages\CreateRecord;

abstract class BaseCreateRecord extends CreateRecord
{
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // Inyecta el usuario directamente en backend, de forma segura
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }
}
