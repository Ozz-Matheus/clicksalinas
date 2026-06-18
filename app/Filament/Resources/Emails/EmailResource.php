<?php

declare(strict_types=1);

namespace App\Filament\Resources\Emails;

use App\Filament\Resources\Emails\Pages\ListEmails;
use App\Filament\Resources\Emails\Schemas\EmailInfolist;
use App\Filament\Resources\Emails\Tables\EmailsTable;
use App\Models\Email;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EmailResource extends Resource
{
    protected static ?string $model = Email::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Mensaje de Contacto';

    protected static ?string $pluralModelLabel = 'Mensajes de Contacto';

    protected static ?string $navigationLabel = 'Buzón de Contacto';

    protected static UnitEnum|string|null $navigationGroup = 'Gestión de Mensajes';

    public static function infolist(Schema $schema): Schema
    {
        return EmailInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmailsTable::configure($table);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmails::route('/'),
        ];
    }
}
