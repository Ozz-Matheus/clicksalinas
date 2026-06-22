<?php

declare(strict_types=1);

namespace App\Filament\Resources\Reservations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReservationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos de la Reserva')
                    ->schema([
                        TextInput::make('reference')
                            ->label('Referencia')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->disabledOn('edit'),
                        Select::make('service_id')
                            ->label('Servicio')
                            ->relationship('service', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disabledOn('edit'),
                    ])->columns(2),

                Section::make('Información del Cliente')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required(),
                        TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->email()
                            ->required(),
                    ])->columns(3),

                Section::make('Detalles del Pago')
                    ->schema([
                        TextInput::make('amount')
                            ->label('Anticipo Pagado')
                            ->numeric()
                            ->required()
                            ->prefix('$')
                            ->disabledOn('edit'),
                        Select::make('status')
                            ->label('Estado')
                            ->options([
                                'pending' => 'Pendiente',
                                'paid' => 'Pagado',
                                'rejected' => 'Rechazado',
                                'voided' => 'Anulado',
                                'void_rejected' => 'Anulación Rechazada',
                            ])
                            ->default('pending')
                            ->required(),
                    ])->columns(2),
            ]);
    }
}
