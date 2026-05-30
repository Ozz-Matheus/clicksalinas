<?php

namespace App\Filament\Resources\Posts;

use App\Filament\RelationManagers\MediaRelationManager;
use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Filament\Resources\Posts\Schemas\PostForm;
use App\Filament\Resources\Posts\Tables\PostsTable;
use App\Models\Post;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::PencilSquare;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return 'Publicación';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Publicaciones';
    }

    public static function getNavigationLabel(): string
    {
        return 'Publicaciones';
    }

    public static function getNavigationGroup(): string
    {
        return 'Gestión del Blog';
    }

    public static function form(Schema $schema): Schema
    {
        return PostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            MediaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Filament Shield crea el rol 'super_admin' por defecto.
        // Si el usuario NO es super admin, solo cargamos los posts que le pertenecen.
        if (! auth()->user()->hasRole('super_admin')) {
            $query->where('user_id', auth()->id());
        }

        return $query;
    }
}
