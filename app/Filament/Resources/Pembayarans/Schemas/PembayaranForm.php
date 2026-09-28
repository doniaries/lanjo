<?php

namespace App\Filament\Resources\Pembayarans\Schemas;

use App\Models\Pesanan;
use App\Models\User;
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
                Select::make('pesanan_id')
                    ->label('Nomor Nota')
                    ->relationship('pesanan', 'nomor_nota')
                    ->options(fn () => Pesanan::orderByDesc('created_at')->pluck('nomor_nota', 'id'))
                    ->searchable()
                    ->required(),

                Select::make('metode')
                    ->label('Metode Bayar')
                    ->options([
                        'tunai'    => '💵 Tunai',
                        'transfer' => '🏦 Transfer',
                        'qris'     => '📱 QRIS',
                    ])
                    ->default('tunai')
                    ->required(),

                TextInput::make('jumlah_bayar')
                    ->label('Jumlah Bayar')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                TextInput::make('kembalian')
                    ->label('Kembalian')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0),

                DateTimePicker::make('waktu_bayar')
                    ->label('Waktu Bayar')
                    ->default(now())
                    ->required(),

                Select::make('kasir_id')
                    ->label('Kasir')
                    ->relationship('kasir', 'name')
                    ->options(fn () => User::orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
            ]);
    }
}
