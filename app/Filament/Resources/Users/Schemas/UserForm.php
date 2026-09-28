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
                                    ->required(),
                                TextInput::make('email')
                                    ->label('Alamat Email')
                                    ->email()
                                    ->required(),
                                TextInput::make('kontak')
                                    ->label('Nomor Kontak')
                                    ->prefix('+62')
                                    ->tel(),
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('password')
                                            ->label('Password')
                                            ->helperText('Kosongkan jika tidak ingin mengubah password')
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
                                FileUpload::make('avatar_url')
                                    ->label('Foto Profil')
                                    ->avatar()
                                    ->imageEditor()
                                    ->circleCropper()
                                    ->directory('photo profil')
                                    ->disk('public')
                                    ->image()
                                    ->maxSize(1024),
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
