<?php

namespace App\Filament\Resources\Photographs;

use App\Filament\Resources\Photographs\Pages\CreatePhotograph;
use App\Filament\Resources\Photographs\Pages\EditPhotograph;
use App\Filament\Resources\Photographs\Pages\ListPhotographs;
use App\Filament\Resources\Photographs\Schemas\PhotographForm;
use App\Filament\Resources\Photographs\Tables\PhotographsTable;
use App\Models\Photograph;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PhotographResource extends Resource
{
    protected static ?string $model = Photograph::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PhotographForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PhotographsTable::configure($table);
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
            'index' => ListPhotographs::route('/'),
            'create' => CreatePhotograph::route('/create'),
            'edit' => EditPhotograph::route('/{record}/edit'),
        ];
    }
}
