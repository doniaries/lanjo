<?php

namespace App\Filament\Resources\Pengaturans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PengaturanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_toko')
                    ->required(),
                Textarea::make('alamat')
                    ->columnSpanFull(),
                TextInput::make('telepon')
                    ->tel(),
                Select::make('tipe_toko')
                    ->options(['restoran' => 'Restoran', 'katering' => 'Katering'])
                    ->default('restoran')
                    ->required(),
                TextInput::make('pajak_default')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('nama_pimpinan')
                    ->label('Nama Pimpinan')
                    ->maxLength(255),
                \Filament\Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->disk('public')
                    ->directory('pengaturan')
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg'])
                    ->imageEditor(),
            ]);
    }
}
