<?php

namespace App\Filament\Resources\KategoriMenus;

use App\Filament\Resources\KategoriMenus\Pages\CreateKategoriMenu;
use App\Filament\Resources\KategoriMenus\Pages\EditKategoriMenu;
use App\Filament\Resources\KategoriMenus\Pages\ListKategoriMenus;
use App\Filament\Resources\KategoriMenus\Schemas\KategoriMenuForm;
use App\Filament\Resources\KategoriMenus\Tables\KategoriMenusTable;
use App\Models\KategoriMenu;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KategoriMenuResource extends Resource
{
    protected static ?string $model = KategoriMenu::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';
    public static function getNavigationGroup(): ?string
    {
        return 'Katalog Menu';
    }
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return KategoriMenuForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KategoriMenusTable::configure($table);
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
            'index' => ListKategoriMenus::route('/'),
            'create' => CreateKategoriMenu::route('/create'),
            'edit' => EditKategoriMenu::route('/{record}/edit'),
        ];
    }
}
