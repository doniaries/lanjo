<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Usaha;
use Spatie\Permission\Models\Role;

class Register extends BaseRegister
{
        return $schema->components([
            Section::make('Data Pengguna')
                ->description('Informasi akun Anda')
                ->schema([
                    $this->getNameFormComponent()
                        ->label('Nama Lengkap')
                        ->placeholder('Contoh: Budi Santoso'),
                    $this->getEmailFormComponent()
                        ->placeholder('contoh@email.com'),
                    TextInput::make('kontak')
                        ->label('Nomor WhatsApp (Wajib Aktif)')
                        ->placeholder('Contoh: 081234567890')
                        ->tel()
                        ->required()
                        ->dehydrateStateUsing(function (string $state) {
                            $number = preg_replace('/[^0-9]/', '', $state);
                            if (str_starts_with($number, '0')) {
                                return '62' . substr($number, 1);
                            }
                            return $number;
                        }),
                    $this->getPasswordFormComponent()
                        ->label('Kata Sandi')
                        ->placeholder('Masukan minimal 8 karakter')
                        ->password()
                        ->required()
                        ->minLength(8)
                        ->maxLength(255)
                        ->revealable(filament()->arePasswordsRevealable())
                        ->dehydrateStateUsing(fn($state) => \Illuminate\Support\Facades\Hash::make($state))
                        ->validationMessages([
                            'required' => 'Kata sandi wajib diisi.',
                            'min' => 'Kata sandi minimal 8 karakter.'
                        ]),
                    $this->getPasswordConfirmationFormComponent()->label('Konfirmasi Kata Sandi')
                        ->placeholder('Ketik ulang kata sandi')
                        ->password()
                        ->required()
                        ->same('password')
                        ->revealable(filament()->arePasswordsRevealable())
                        ->dehydrated(false)
                        ->validationMessages([
                            'required' => 'Konfirmasi kata sandi wajib diisi.',
                            'same' => 'Konfirmasi kata sandi tidak cocok dengan kata sandi awal.',
                        ]),
                    FileUpload::make('avatar_url')
                        ->label('Foto Profil (Opsional)')
                        ->avatar()
                        ->imageEditor()
                        ->circleCropper()
                        ->disk('profile-photos')
                        ->image()
                        ->maxSize(1024),
                ]),
                
            Section::make('Data Usaha')
                ->description('Informasi usaha')
                ->schema([
                    TextInput::make('nama_usaha')
                        ->label('Nama Usaha')
                        ->required()
                        ->live(debounce: 200)
                        ->afterStateUpdated(fn (\Filament\Schemas\Components\Utilities\Set $set, ?string $state) => $set('slug', Str::slug($state ?? '')))
                        ->maxLength(255),
                    TextInput::make('slug')
                        ->label('Slug Usaha')
                        ->required()
                        ->readOnly()
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
        ]);
    }

    protected function handleRegistration(array $data): Model
    {
        // 1. Buat Usaha / Tenant
        $usaha = Usaha::create([
            'nama_usaha' => $data['nama_usaha'],
            'slug'       => $data['slug'],
            'tipe_usaha' => $data['tipe_usaha'],
            'pajak_aktif' => false,
            'pajak_default' => 0,
        ]);

        // 2. Buat User
        $data['is_active'] = true;
        $data['tipe'] = 'pemilik';
        $data['usaha_id'] = $usaha->id;

        // Hilangkan data Usaha dari array $data sebelum create User
        unset($data['nama_usaha'], $data['slug'], $data['tipe_usaha']);

        $user = $this->getUserModel()::create($data);

        if (class_exists(Role::class)) {
            $role = Role::firstOrCreate(['name' => 'pemilik', 'guard_name' => 'web']);
            $user->assignRole($role);
        }

        return $user;
    }
}
