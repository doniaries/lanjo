<?php

namespace App\Filament\Resources\Pesanans;

use App\Filament\Resources\Pesanans\Pages\CreatePesanan;
use App\Filament\Resources\Pesanans\Pages\EditPesanan;
use App\Filament\Resources\Pesanans\Pages\ListPesanans;
use App\Filament\Resources\Pesanans\Schemas\PesananForm;
use App\Filament\Resources\Pesanans\Tables\PesanansTable;
use App\Models\Pesanan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PesananResource extends Resource
{
    protected static ?string $model = Pesanan::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';
    public static function getNavigationGroup(): ?string
    {
        return 'Transaksi';
    }
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return PesananForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PesanansTable::configure($table);
    }

    public static function infolist(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                \Filament\Infolists\Components\Section::make('Informasi Pesanan')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('nomor_nota')->label('No. Nota')->weight('bold'),
                        \Filament\Infolists\Components\TextEntry::make('tanggal')->dateTime('d M Y H:i'),
                        \Filament\Infolists\Components\TextEntry::make('meja.nomor_meja')->label('Meja')->default('-'),
                        \Filament\Infolists\Components\TextEntry::make('tipe_pesanan')
                            ->formatStateUsing(fn ($state) => $state === 'dine_in' ? 'Dine In' : 'Take Away')
                            ->badge(),
                        \Filament\Infolists\Components\TextEntry::make('kasir.name')->label('Kasir'),
                        \Filament\Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn ($state) => match ($state) {
                                'selesai' => 'success',
                                'batal' => 'danger',
                                default => 'warning',
                            }),
                        \Filament\Infolists\Components\TextEntry::make('catatan')->columnSpanFull(),
                    ])->columns(3),
                \Filament\Infolists\Components\Section::make('Total')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('subtotal')->formatStateUsing(fn ($state) => format_rupiah($state)),
                        \Filament\Infolists\Components\TextEntry::make('diskon')->formatStateUsing(fn ($state) => format_rupiah($state)),
                        \Filament\Infolists\Components\TextEntry::make('pajak')->formatStateUsing(fn ($state) => format_rupiah($state)),
                        \Filament\Infolists\Components\TextEntry::make('total_akhir')->label('Total Akhir')->weight('bold')->color('primary')->formatStateUsing(fn ($state) => format_rupiah($state)),
                    ])->columns(4),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\Pesanans\RelationManagers\DetailPesanansRelationManager::class,
            \App\Filament\Resources\Pesanans\RelationManagers\PembayaransRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPesanans::route('/'),
            'create' => CreatePesanan::route('/create'),
            'view' => \App\Filament\Resources\Pesanans\Pages\ViewPesanan::route('/{record}'),
            'edit' => EditPesanan::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        $role = strtolower(auth()->user()->role ?? '');
        return in_array($role, ['superadmin', 'admin', 'super_admin']);
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        $role = strtolower(auth()->user()->role ?? '');
        return in_array($role, ['superadmin', 'admin', 'super_admin']);
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        $role = strtolower(auth()->user()->role ?? '');
        return in_array($role, ['superadmin', 'admin', 'super_admin']);
    }
}
