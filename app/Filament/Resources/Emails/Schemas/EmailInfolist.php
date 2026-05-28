<?php

namespace App\Filament\Resources\Emails\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EmailInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nombre'),
                TextEntry::make('email')
                    ->label('Correo Electrónico'),
                TextEntry::make('phone')
                    ->label('Teléfono'),
                TextEntry::make('message')
                    ->label('Mensaje')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Última Actualización')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
