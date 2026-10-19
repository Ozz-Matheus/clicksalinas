<?php

namespace App\Filament\Resources\Emails\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmailInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información del Remitente')
                    ->schema([
                        TextEntry::make('email')
                            ->label('Correo Electrónico')
                            ->icon('heroicon-m-envelope'),
                        TextEntry::make('phone')
                            ->label('Teléfono')
                            ->icon('heroicon-m-phone'),
                        TextEntry::make('ip_address')
                            ->label('IP de origen')
                            ->placeholder('No registrada'),
                        TextEntry::make('user_agent')
                            ->label('Navegador / User-Agent')
                            ->placeholder('No registrado')
                            ->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->label('Fecha de Recepción')
                            ->dateTime('d/m/Y H:i:s'),
                    ]),

                Section::make('Mensaje')
                    ->schema([
                        TextEntry::make('message')
                            ->label('Contenido del Mensaje')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
