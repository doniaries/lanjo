<?php

namespace App\Filament\Resources\MutasiStoks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MutasiStokForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DateTimePicker::make('tanggal')
                    ->required(),
                TextInput::make('menu_id')
                    ->required()
                    ->numeric(),
                Select::make('tipe')
                    ->options(['masuk' => 'Masuk', 'keluar' => 'Keluar', 'penyesuaian' => 'Penyesuaian'])
                    ->required(),
                TextInput::make('jumlah')
                    ->required()
                    ->numeric(),
                TextInput::make('stok_sebelum')
                    ->required()
                    ->numeric(),
                TextInput::make('stok_sesudah')
                    ->required()
                    ->numeric(),
                TextInput::make('keterangan'),
                TextInput::make('pengguna_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
