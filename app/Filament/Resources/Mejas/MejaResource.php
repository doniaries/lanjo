<?php

namespace App\Filament\Resources\Mejas;

use App\Filament\Resources\Mejas\Pages\CreateMeja;
use App\Filament\Resources\Mejas\Pages\EditMeja;
use App\Filament\Resources\Mejas\Pages\ListMejas;
use App\Filament\Resources\Mejas\Schemas\MejaForm;
use App\Filament\Resources\Mejas\Tables\MejasTable;
use App\Models\Meja;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MejaResource extends Resource
{
    protected static ?string $model = Meja::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return MejaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MejasTable::configure($table);
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
            'index' => ListMejas::route('/'),
            'create' => CreateMeja::route('/create'),
            'edit' => EditMeja::route('/{record}/edit'),
        ];
    }
}
