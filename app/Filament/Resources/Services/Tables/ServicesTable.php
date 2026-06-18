<?php

namespace App\Filament\Resources\Services\Tables;

use App\Filament\Tables\Columns\TableDefaults;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Precio Total')
                    ->money('COP', divideBy: 1)
                    ->sortable(),
                TextColumn::make('deposit_amount')
                    ->label('Anticipo')
                    ->money('COP', divideBy: 1)
                    ->sortable(),
                ...TableDefaults::timestamps(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
