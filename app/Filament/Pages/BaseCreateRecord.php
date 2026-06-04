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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $model = new ($this->getModel());

        if (auth()->check() && $model->isFillable('user_id')) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }
}
