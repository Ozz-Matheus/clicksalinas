<?php

namespace App\Filament\Resources\Albums\Pages;

use App\Filament\Resources\Albums\AlbumResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditAlbum extends EditRecord
{
    protected static string $resource = AlbumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview')
                ->label('Ver')
                ->icon(Heroicon::Eye)
                ->url(fn ($record): string => route('portfolio.album', $record))
                ->openUrlInNewTab(),
            DeleteAction::make(),
        ];
    }
}
