<?php

namespace App\Filament\Resources\Pembayarans\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PembayaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pesanan_id')
                    ->required()
                    ->numeric(),
                Select::make('metode')
                    ->options(['tunai' => 'Tunai', 'qris' => 'Qris', 'transfer' => 'Transfer'])
                    ->default('tunai')
                    ->required(),
                TextInput::make('jumlah_bayar')
                    ->required()
                    ->numeric(),
                TextInput::make('kembalian')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                DateTimePicker::make('waktu_bayar')
                    ->required(),
                TextInput::make('kasir_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
