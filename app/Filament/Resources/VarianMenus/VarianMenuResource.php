<?php

namespace App\Filament\Resources\VarianMenus;

use App\Filament\Resources\VarianMenus\Pages\CreateVarianMenu;
use App\Filament\Resources\VarianMenus\Pages\EditVarianMenu;
use App\Filament\Resources\VarianMenus\Pages\ListVarianMenus;
use App\Filament\Resources\VarianMenus\Schemas\VarianMenuForm;
use App\Filament\Resources\VarianMenus\Tables\VarianMenusTable;
use App\Models\VarianMenu;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VarianMenuResource extends Resource
{
    protected static ?string $model = VarianMenu::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-adjustments-horizontal';
    protected static ?string $navigationGroup = 'Katalog Menu';
    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return VarianMenuForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VarianMenusTable::configure($table);
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
            'index' => ListVarianMenus::route('/'),
            'create' => CreateVarianMenu::route('/create'),
            'edit' => EditVarianMenu::route('/{record}/edit'),
        ];
    }
}
