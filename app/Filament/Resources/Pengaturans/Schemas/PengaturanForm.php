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
                    ->required()
                    ->prefixIcon('heroicon-m-building-storefront')
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Nama toko ini sudah ada, mohon gunakan nama lain.',
                    ])
                    ->maxLength(255),
                Textarea::make('alamat')
                    ->columnSpanFull(),
                TextInput::make('telepon')
                    ->tel()
                    ->prefixIcon('heroicon-m-phone')
                    ->regex('/^(0|62|\+62)8[1-9][0-9]{6,10}$/')
                    ->validationMessages([
                        'regex' => 'Format nomor tidak valid. Pastikan dimulai dengan 08 atau 628 dan berisi 10-14 digit angka.',
                    ]),
                Select::make('tipe_toko')
                    ->prefixIcon('heroicon-m-tag')
                    ->options(['restoran' => 'Restoran', 'katering' => 'Katering'])
                    ->default('restoran')
                    ->required(),
                TextInput::make('pajak_default')
                    ->required()
                    ->prefixIcon('heroicon-m-receipt-percent')
                    ->numeric()
                    ->default(0.0),
                \Filament\Forms\Components\Toggle::make('pajak_aktif')
                    ->label('Aktifkan Pajak di POS')
                    ->default(false),
                TextInput::make('nama_pimpinan')
                    ->label('Nama Pimpinan')
                    ->prefixIcon('heroicon-m-user')
                    ->maxLength(255),
                Textarea::make('footer_struk')
                    ->label('Footer Struk')
                    ->columnSpanFull()
                    ->placeholder('Contoh: Terima kasih atas kunjungan Anda...'),
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
