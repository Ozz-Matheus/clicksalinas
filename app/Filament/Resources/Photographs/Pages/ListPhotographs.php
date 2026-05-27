<?php

namespace App\Filament\Resources\Photographs\Pages;

use App\Filament\Resources\Photographs\PhotographResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPhotographs extends ListRecords
{
    protected static string $resource = PhotographResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
