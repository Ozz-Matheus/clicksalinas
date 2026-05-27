<?php

namespace App\Filament\Resources\Photographs\Pages;

use App\Filament\Resources\Photographs\PhotographResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPhotograph extends EditRecord
{
    protected static string $resource = PhotographResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
