<?php

declare(strict_types=1);

namespace App\Filament\Resources\Reservations\Schemas;

use Filament\Actions\Action;
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
                        // Ocultamos la referencia en la creación, se autogenera en el modelo
                        TextInput::make('reference')
                            ->label('Referencia')
                            ->unique(ignoreRecord: true)
                            ->disabled()
                            ->visibleOn('edit'),

                        Select::make('service_id')
                            ->label('Servicio')
                            ->relationship('service', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disabledOn('edit'),

                        TextInput::make('crm_task_id')
                            ->label('ID de Tarea')
                            ->maxLength(255)
                            ->placeholder('Ej: CU-5487 (Opcional)'),
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
                    ])->columns(2),

                Section::make('Detalles del Pago')
                    ->schema([
                        TextInput::make('amount')
                            ->label('Anticipo a Cobrar')
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

                Section::make('Enlace de Pago para el Cliente')
                    ->schema([
                        TextInput::make('url_pago')
                            ->label('URL Segura (UUID)')
                            // Generamos la ruta asumiendo que tienes configurado Route Model Binding con el UUID
                            ->formatStateUsing(fn ($record) => $record ? route('checkout.show', $record->uuid) : '')
                            ->disabled()
                            ->dehydrated(false)
                            ->suffixAction(
                                Action::make('copy')
                                    ->icon('heroicon-m-clipboard')
                                    ->action(fn ($state, $livewire) => $livewire->js("window.navigator.clipboard.writeText('{$state}')"))
                            ),
                    ])
                    ->visibleOn('edit'), // Solo visible cuando el registro ya se guardó
            ]);
    }
}
