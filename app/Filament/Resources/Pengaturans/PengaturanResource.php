<?php

namespace App\Filament\Resources\Pengaturans;

use App\Filament\Resources\Pengaturans\Pages\CreatePengaturan;
use App\Filament\Resources\Pengaturans\Pages\EditPengaturan;
use App\Filament\Resources\Pengaturans\Pages\ListPengaturans;
use App\Filament\Resources\Pengaturans\Schemas\PengaturanForm;
use App\Filament\Resources\Pengaturans\Tables\PengaturansTable;
use App\Models\Pengaturan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PengaturanResource extends Resource
{
    protected static ?string $model = Pengaturan::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-8-tooth';
    public static function getNavigationGroup(): ?string
    {
        return 'Pengaturan';
    }
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'id';

    public static function canAccess(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        if ($user && $user->isSuperadmin()) {
            return true;
        }

        $usaha = $user->usaha;
        if ($usaha && $usaha->isFree()) {
            return false; 
        }

        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return PengaturanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengaturansTable::configure($table);
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
            'index' => ListPengaturans::route('/'),
            'create' => CreatePengaturan::route('/create'),
            'edit' => EditPengaturan::route('/{record}/edit'),
        ];
    }
}
