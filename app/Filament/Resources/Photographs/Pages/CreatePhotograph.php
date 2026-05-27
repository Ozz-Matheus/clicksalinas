<?php

namespace App\Filament\Resources\Photographs\Pages;

use App\Filament\Resources\Photographs\PhotographResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePhotograph extends CreateRecord
{
    protected static string $resource = PhotographResource::class;
}
