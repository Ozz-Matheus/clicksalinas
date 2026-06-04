<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview')
                ->label('Ver')
                ->icon(Heroicon::Eye)
                ->url(fn ($record): string => route('blog.show', $record))
                ->openUrlInNewTab(),
            DeleteAction::make(),
        ];
    }
}
