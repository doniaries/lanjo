<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kategori_menu_id')
                    ->required()
                    ->numeric(),
                TextInput::make('nama')
                    ->required(),
                TextInput::make('harga_jual')
                    ->required()
                    ->numeric(),
                TextInput::make('harga_modal')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('gambar'),
                TextInput::make('stok')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('status_aktif')
                    ->required(),
            ]);
    }
}
