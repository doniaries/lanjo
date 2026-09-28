<?php

namespace App\Filament\Resources\Menus\Schemas;

use App\Models\KategoriMenu;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kategori_menu_id')
                    ->label('Kategori Menu')
                    ->options(KategoriMenu::query()->orderBy('urutan')->pluck('nama', 'id'))
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('nama')
                    ->label('Nama Menu')
                    ->required()
                    ->maxLength(255),
                TextInput::make('harga_jual')
                    ->label('Harga Jual (Rp)')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('harga_modal')
                    ->label('Harga Modal (Rp)')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('Rp'),
                FileUpload::make('gambar')
                    ->label('Gambar Menu')
                    ->image()
                    ->disk('public')
                    ->directory('menus')
                    ->nullable(),
                TextInput::make('stok')
                    ->label('Stok')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0),
                Toggle::make('status_aktif')
                    ->label('Aktif')
                    ->default(true)
                    ->required(),
            ]);
    }
}
