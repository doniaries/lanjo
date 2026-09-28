<?php

namespace App\Filament\Resources\DetailPesanans\Schemas;

use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\VarianMenu;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DetailPesananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('pesanan_id')
                    ->label('Pesanan (No. Nota)')
                    ->relationship('pesanan', 'nomor_nota')
                    ->options(fn () => Pesanan::orderByDesc('created_at')->pluck('nomor_nota', 'id'))
                    ->searchable()
                    ->required(),

                Select::make('menu_id')
                    ->label('Menu')
                    ->relationship('menu', 'nama')
                    ->options(fn () => Menu::where('status_aktif', true)->orderBy('nama')->pluck('nama', 'id'))
                    ->searchable()
                    ->required(),

                Select::make('varian_menu_id')
                    ->label('Varian')
                    ->relationship('varianMenu', 'nama_varian')
                    ->options(fn () => VarianMenu::orderBy('nama_varian')->pluck('nama_varian', 'id'))
                    ->searchable()
                    ->nullable()
                    ->placeholder('-- Tanpa Varian --'),

                TextInput::make('nama_menu_snapshot')
                    ->label('Nama Menu (Snapshot)')
                    ->required(),

                TextInput::make('harga_satuan_snapshot')
                    ->label('Harga Satuan')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->minValue(1)
                    ->required(),

                TextInput::make('subtotal')
                    ->label('Subtotal')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                Textarea::make('catatan_item')
                    ->label('Catatan Item')
                    ->columnSpanFull(),
            ]);
    }
}
