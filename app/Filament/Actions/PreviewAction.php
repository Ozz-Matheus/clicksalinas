<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Contracts\Indexable;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;

class PreviewAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'preview';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Ver')
            ->icon(Heroicon::Eye)
            ->openUrlInNewTab()
            ->url(function (Model $record): ?string {
                return $record instanceof Indexable ? $record->getIndexableUrl() : null;
            });
    }
}
