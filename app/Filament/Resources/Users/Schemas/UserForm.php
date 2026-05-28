<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make()
                    ->columns(3)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Correo electrónico')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('password')
                            ->label('Contraseña')
                            ->password()
                            ->maxLength(255)
                            ->nullable()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context) => $context === 'create')
                            ->helperText(
                                fn (string $context) => $context === 'edit'
                                    ? 'Dejar en blanco si no desea cambiar su contraseña'
                                    : null
                            ),
                        CheckboxList::make('roles')
                            ->label('Roles')
                            ->relationship(
                                name: 'roles',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query
                                    ->when(! auth()->user()->hasRole('super_admin'), fn ($q) => $q->where('name', '!=', 'super_admin'))
                            )
                            ->bulkToggleable()
                            ->getOptionLabelFromRecordUsing(fn ($record) => Str::headline($record->name))
                            ->disabled(fn ($record) => auth()->user()->hasRole('super_admin') && $record?->is(auth()->user()))
                            ->columnSpanFull()
                            ->columns(3),

                    ]),

            ])->columns(1);
    }
}
