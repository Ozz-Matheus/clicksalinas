<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Filament\Tables\Columns\TableDefaults;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->limit(60)
                    ->searchable(),
                TextColumn::make('excerpt')
                    ->label('Extracto')
                    ->limit(30)
                    ->searchable(),
                TextColumn::make('published_at')
                    ->label('Fecha de Publicación')
                    ->since()
                    ->dateTooltip()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Categoría')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('owner.name')
                    ->label('Propietario')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ...TableDefaults::timestamps(),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('preview')
                    ->label('Ver')
                    ->icon(Heroicon::Eye)
                    ->url(fn ($record): string => route('blog.show', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
