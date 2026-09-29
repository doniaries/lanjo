<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class EditUsahaProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Profil Usaha';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Detail Usaha')
                    ->description('Perbarui informasi utama mengenai usaha Anda.')
                    ->schema([
                        TextInput::make('nama_usaha')
                            ->label('Nama Usaha')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->disabled()
                            ->helperText('Slug otomatis tidak bisa diubah.'),
                        Textarea::make('alamat')
                            ->label('Alamat Lengkap')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        TextInput::make('telepon')
                            ->label('Telepon')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('tipe_usaha')
                            ->label('Tipe Usaha')
                            ->disabled(),
                    ])->columns(2),

                Section::make('Pajak & Biaya')
                    ->description('Atur pengaturan default pajak.')
                    ->schema([
                        Toggle::make('pajak_aktif')
                            ->label('Aktifkan Pajak')
                            ->inline(false),
                        TextInput::make('pajak_default')
                            ->label('Besaran Pajak (%)')
                            ->numeric()
                            ->default(0.00)
                            ->required(),
                    ])->columns(2),
            ]);
    }
}
