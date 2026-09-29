<?php

namespace App\Filament\Resources\DetailPesanans;

use App\Filament\Resources\DetailPesanans\Pages\CreateDetailPesanan;
use App\Filament\Resources\DetailPesanans\Pages\EditDetailPesanan;
use App\Filament\Resources\DetailPesanans\Pages\ListDetailPesanans;
use App\Filament\Resources\DetailPesanans\Schemas\DetailPesananForm;
use App\Filament\Resources\DetailPesanans\Tables\DetailPesanansTable;
use App\Models\DetailPesanan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DetailPesananResource extends Resource
{
    protected static ?string $model = DetailPesanan::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static bool $shouldRegisterNavigation = false;
    protected static bool $isScopedToTenant = false;

    public static function getNavigationGroup(): ?string
    {
        return 'Transaksi';
    }
    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return DetailPesananForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DetailPesanansTable::configure($table);
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
            'index' => ListDetailPesanans::route('/'),
            'create' => CreateDetailPesanan::route('/create'),
            'edit' => EditDetailPesanan::route('/{record}/edit'),
        ];
    }
}
