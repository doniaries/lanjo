<?php

namespace App\Filament\Resources\TipeUsahas;

use App\Filament\Resources\TipeUsahas\Pages\CreateTipeUsaha;
use App\Filament\Resources\TipeUsahas\Pages\EditTipeUsaha;
use App\Filament\Resources\TipeUsahas\Pages\ListTipeUsahas;
use App\Filament\Resources\TipeUsahas\Schemas\TipeUsahaForm;
use App\Filament\Resources\TipeUsahas\Tables\TipeUsahasTable;
use App\Models\TipeUsaha;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TipeUsahaResource extends Resource
{
    protected static ?string $model = TipeUsaha::class;

    protected static bool $isScopedToTenant = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getNavigationGroup(): ?string
    {
        return 'Master Data';
    }

    public static function form(Schema $schema): Schema
    {
        return TipeUsahaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TipeUsahasTable::configure($table);
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
            'index' => ListTipeUsahas::route('/'),
            'create' => CreateTipeUsaha::route('/create'),
            'edit' => EditTipeUsaha::route('/{record}/edit'),
        ];
    }
}
