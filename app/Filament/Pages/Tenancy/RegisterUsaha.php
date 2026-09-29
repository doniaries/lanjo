<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Usaha;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Schemas\Schema;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RegisterUsaha extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Pendaftaran Usaha';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Data Usaha')
                        ->description('Informasi usaha Anda.')
                        ->schema([
                            TextInput::make('nama_usaha')
                                ->label('Nama Usaha')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (string $operation, $state, \Filament\Forms\Set $set) => $set('slug', Str::slug($state)))
                                ->maxLength(255),
                            TextInput::make('slug')
                                ->label('Slug Usaha')
                                ->required()
                                ->unique('usahas', 'slug')
                                ->maxLength(255),
                            Select::make('tipe_usaha')
                                ->label('Tipe Usaha')
                                ->options([
                                    'restoran' => 'Restoran / Rumah Makan',
                                    'katering' => 'Katering',
                                ])
                                ->required(),
                        ]),
                    Wizard\Step::make('Detail Profil')
                        ->description('Atur identitas Anda.')
                        ->schema([
                            // Karena user sudah terdaftar di auth, kita bisa mengizinkan update nama pengguna
                            TextInput::make('nama_pengguna')
                                ->label('Nama Lengkap')
                                ->default(fn () => auth()->user()->name)
                                ->required()
                                ->maxLength(255),
                            Select::make('status')
                                ->label('Status Anda')
                                ->options([
                                    'pemilik' => 'Pemilik',
                                    'karyawan' => 'Karyawan',
                                ])
                                ->default('pemilik')
                                ->required(),
                        ]),
                ])
                ->submitAction(new \Illuminate\Support\HtmlString('<button type="submit" class="fi-btn fi-btn-size-md fi-btn-color-primary fi-btn-labeled">Daftar Usaha</button>')),
            ]);
    }

    protected function handleRegistration(array $data): Model
    {
        // 1. Buat Tenant Usaha
        $usaha = Usaha::create([
            'nama_usaha' => $data['nama_usaha'],
            'slug'       => $data['slug'],
            'tipe_usaha' => $data['tipe_usaha'],
            'pajak_aktif' => false,
            'pajak_default' => 0,
        ]);

        // 2. Update Data User
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        $user->update([
            'usaha_id' => $usaha->id,
            'name'     => $data['nama_pengguna'],
            'tipe'     => $data['status'],
        ]);

        return $usaha;
    }
}
