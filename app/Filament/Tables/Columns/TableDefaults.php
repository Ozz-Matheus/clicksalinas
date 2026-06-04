<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class TableDefaults
{
    public static function timestamps(): array
    {
        return [
            TextColumn::make('created_at')
                ->label('Fecha de Creación')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->label('Fecha de Actualización')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
