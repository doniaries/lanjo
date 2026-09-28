<?php

namespace App\Filament\Resources\Pesanans\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PesananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nomor_nota')
                    ->required(),
                DateTimePicker::make('tanggal')
                    ->required(),
                TextInput::make('meja_id')
                    ->numeric(),
                Select::make('tipe_pesanan')
                    ->options(['dine_in' => 'Dine in', 'take_away' => 'Take away'])
                    ->default('dine_in')
                    ->required(),
                TextInput::make('kasir_id')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options(['baru' => 'Baru', 'selesai' => 'Selesai', 'batal' => 'Batal'])
                    ->default('baru')
                    ->required(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('diskon_nilai')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('pajak_nilai')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_akhir')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Textarea::make('catatan')
                    ->columnSpanFull(),
            ]);
    }
}
