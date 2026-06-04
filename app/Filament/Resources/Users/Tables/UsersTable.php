<?php

namespace App\Filament\Resources\Users\Tables;

use App\Filament\Tables\Columns\TableDefaults;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Correo electrónico')
                    ->copyable()
                    ->copyMessage('Copiado al portapapeles')
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label('Roles')
                    ->formatStateUsing(fn ($state) => Str::headline($state))
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'success',
                        default => 'info',
                    }),
                TextColumn::make('email_verified_at')
                    ->label('Correo electrónico verificado en')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                ]),
            ]);
    }
}
