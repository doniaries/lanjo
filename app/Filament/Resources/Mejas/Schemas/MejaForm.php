<?php

namespace App\Filament\Resources\Mejas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MejaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nomor_meja')
                    ->required(),
                Select::make('status')
                    ->options(['kosong' => 'Kosong', 'terisi' => 'Terisi'])
                    ->default('kosong')
                    ->required(),
            ]);
    }
}
