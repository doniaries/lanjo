<?php

namespace App\Filament\Resources\DetailPesanans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DetailPesananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pesanan_id')
                    ->required()
                    ->numeric(),
                TextInput::make('menu_id')
                    ->required()
                    ->numeric(),
                TextInput::make('varian_menu_id')
                    ->numeric(),
                TextInput::make('nama_menu_snapshot')
                    ->required(),
                TextInput::make('harga_satuan_snapshot')
                    ->required()
                    ->numeric(),
                TextInput::make('jumlah')
                    ->required()
                    ->numeric(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric(),
                TextInput::make('catatan_item'),
            ]);
    }
}
