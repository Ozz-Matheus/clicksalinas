<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Pages\BaseCreateRecord;
use App\Filament\Resources\Posts\PostResource;

class CreatePost extends BaseCreateRecord
{
    protected static string $resource = PostResource::class;
}
