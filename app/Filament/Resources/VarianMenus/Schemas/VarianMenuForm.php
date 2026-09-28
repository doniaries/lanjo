<?php

namespace App\Filament\Resources\VarianMenus\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VarianMenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('menu_id')
                    ->required()
                    ->numeric(),
                TextInput::make('nama_varian')
                    ->required(),
                TextInput::make('harga_tambahan')
                    ->required()
                    ->numeric()
                    ->default(0.0),
            ]);
    }
}
