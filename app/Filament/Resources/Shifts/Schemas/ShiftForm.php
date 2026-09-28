<?php

namespace App\Filament\Resources\Shifts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ShiftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pengguna_id')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('waktu_mulai')
                    ->required(),
                DateTimePicker::make('waktu_selesai'),
                TextInput::make('kas_awal')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('kas_akhir')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Select::make('status')
                    ->options(['buka' => 'Buka', 'tutup' => 'Tutup'])
                    ->default('buka')
                    ->required(),
            ]);
    }
}
