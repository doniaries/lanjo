<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Informasi Pengguna')
                            ->icon('heroicon-o-user')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->prefixIcon('heroicon-m-user')
                                    ->unique(ignoreRecord: true)
                                    ->validationMessages([
                                        'unique' => 'Nama sudah digunakan.',
                                    ])
                                    ->required(),
                                TextInput::make('email')
                                    ->label('Alamat Email')
                                    ->prefixIcon('heroicon-m-envelope')
                                    ->unique(ignoreRecord: true)
                                    ->validationMessages([
                                        'unique' => 'Email ini sudah terdaftar.',
                                    ])
                                    ->email()
                                    ->required(),
                                TextInput::make('kontak')
                                    ->label('Nomor WhatsApp (Wajib Aktif)')
                                    ->placeholder('Contoh: 081234567890')
                                    ->prefixIcon('heroicon-m-phone')
                                    ->tel()
                                    ->unique(ignoreRecord: true)
                                    ->regex('/^(0|62|\+62)8[1-9][0-9]{6,10}$/')
                                    ->validationMessages([
                                        'unique' => 'Nomor WhatsApp ini sudah digunakan.',
                                        'regex' => 'Format nomor WhatsApp tidak valid. Pastikan dimulai dengan 08 atau 628 dan berisi 10-14 digit angka.',
                                    ])
                                    ->dehydrateStateUsing(function (string $state) {
                                        $number = preg_replace('/[^0-9]/', '', $state);
                                        if (str_starts_with($number, '0')) {
                                            return '62' . substr($number, 1);
                                        }
                                        return $number;
                                    }),
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('password')
                                            ->label('Password')
                                            ->helperText('Kosongkan jika tidak ingin mengubah password')
                                            ->prefixIcon('heroicon-m-lock-closed')
                                            ->password()
                                            ->revealable()
                                            ->autocomplete('new-password')
                                            ->rule(Password::default()->mixedCase()->uncompromised(3))
                                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                            ->dehydrated(fn($state) => filled($state))
                                            ->required(fn(string $context): bool => $context === 'create'),
                                        TextInput::make('password_confirmation')
                                            ->label('Konfirmasi Password')
                                            ->helperText('Kosongkan jika tidak ingin mengubah password')
                                            ->prefixIcon('heroicon-m-lock-closed')
                                            ->password()
                                            ->revealable()
                                            ->autocomplete('new-password')
                                            ->required(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                                            ->maxLength(255)
                                            ->same('password')
                                            ->dehydrated(false),
                                    ]),
                            ]),
                    ])
                    ->columnSpan(['default' => 3, 'lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Akses & Status')
                            ->icon('heroicon-o-lock-closed')
                            ->schema([

                                \Filament\Forms\Components\Select::make('roles')
                                    ->label('Peran / Role')
                                    ->relationship('roles', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->searchable(),
                                DateTimePicker::make('email_verified_at')
                                    ->hidden(),
                                Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->default(true)
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['default' => 3, 'lg' => 1]),
            ]);
    }
}
