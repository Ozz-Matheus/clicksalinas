<?php

namespace App\Filament\Resources\Albums\Tables;

use App\Filament\Actions\PreviewAction;
use App\Filament\Tables\Columns\TableDefaults;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AlbumsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título del Álbum')
                    ->limit(60)
                    ->searchable(),
                TextColumn::make('service.name')
                    ->label('Servicio')
                    ->searchable(),
                TextColumn::make('published_at')
                    ->label('Fecha de Publicación')
                    ->since()
                    ->dateTooltip()
                    ->sortable(),
                TextColumn::make('owner.name')
                    ->label('Nombre del Usuario')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ...TableDefaults::timestamps(),

            ])->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('service_id')
                    ->label('Servicio')
                    ->relationship('service', 'name'),
            ])
            ->recordActions([
                PreviewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
