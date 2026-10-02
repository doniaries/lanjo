<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Usaha;
use Spatie\Permission\Models\Role;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Data Pengguna')
                ->description('Informasi akun Anda')
                ->schema([
                    $this->getNameFormComponent()
                        ->label('Nama Lengkap Pemilik')
                        ->placeholder('Contoh: Budi Santoso')
                        ->prefixIcon('heroicon-m-user'),
                    $this->getEmailFormComponent()
                        ->placeholder('contoh@email.com')
                        ->prefixIcon('heroicon-m-envelope'),
                    TextInput::make('kontak')
                        ->label('Nomor WhatsApp (Wajib Aktif)')
                        ->placeholder('Contoh: 081234567890')
                        ->prefixIcon('heroicon-m-phone')
                        ->tel()
                        ->required()
                        ->unique('users', 'kontak')
                        ->regex('/^(0|62|\+62)8[1-9][0-9]{6,10}$/')
                        ->validationMessages([
                            'unique' => 'Nomor WhatsApp ini sudah terdaftar.',
                            'regex' => 'Format nomor WhatsApp tidak valid. Pastikan dimulai dengan 08 atau 628 dan berisi 10-14 digit angka.',
                        ])
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
                        ->prefixIcon('heroicon-m-lock-closed')
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
                        ->prefixIcon('heroicon-m-lock-closed')
                        ->password()
                        ->required()
                        ->same('password')
                        ->revealable(filament()->arePasswordsRevealable())
                        ->dehydrated(false)
                        ->validationMessages([
                            'required' => 'Konfirmasi kata sandi wajib diisi.',
                            'same' => 'Konfirmasi kata sandi tidak cocok dengan kata sandi awal.',
                        ]),
                ]),

            Section::make('Data Usaha')
                ->description('Informasi usaha')
                ->schema([
                    TextInput::make('nama_usaha')
                        ->label('Nama Usaha')
                        ->prefixIcon('heroicon-m-building-storefront')
                        ->required()
                        ->unique(\App\Models\Usaha::class, 'nama_usaha')
                        ->validationMessages([
                            'unique' => 'Nama Usaha ini sudah terdaftar. Silakan pilih nama lain.',
                        ])
                        ->maxLength(255),
                    Select::make('tipe_usaha_id')
                        ->label('Tipe Usaha')
                        ->options(\App\Models\TipeUsaha::pluck('nama', 'id'))
                        ->prefixIcon('heroicon-m-tag')
                        ->searchable()
                        ->preload()
                        ->required(),
                    FileUpload::make('logo')
                        ->label('Logo Usaha (Opsional)')
                        ->image()
                        ->imageEditor()
                        ->directory('logos')
                        ->maxSize(2048) // max 2MB
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->rules(['mimetypes:image/jpeg,image/png,image/webp']) // extra security rule
                        ->helperText('Hanya file JPG, PNG, WEBP. Maksimal 2MB.'),
                ]),
        ]);
    }

    protected function handleRegistration(array $data): Model
    {
        // Generate Slug secara otomatis dan pastikan unik
        $slug = Str::slug($data['nama_usaha']);
        $originalSlug = $slug;
        $counter = 1;
        while (\App\Models\Usaha::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        $data['slug'] = $slug;

        // 1. Buat Usaha / Tenant
        $usaha = Usaha::create([
            'nama_usaha' => $data['nama_usaha'],
            'slug'       => $data['slug'],
            'tipe_usaha_id' => $data['tipe_usaha_id'],
            'logo'       => $data['logo'] ?? null,
            'pajak_aktif' => false,
            'pajak_default' => 0,
        ]);

        // 2. Buat Pengaturan (Profile Toko)
        \App\Models\Pengaturan::create([
            'usaha_id'      => $usaha->id,
            'nama_toko'     => $data['nama_usaha'],
            'telepon'       => $data['kontak'],
            'nama_pimpinan' => $data['name'],
            'pajak_aktif'   => false,
            'pajak_default' => 0,
        ]);

        // 3. Buat User
        $data['is_active'] = true;
        $data['tipe'] = 'pemilik';
        $data['usaha_id'] = $usaha->id;

        // Hilangkan data Usaha dari array $data sebelum create User
        unset($data['nama_usaha'], $data['slug'], $data['tipe_usaha_id'], $data['logo']);

        $user = $this->getUserModel()::create($data);

        if (class_exists(Role::class)) {
            $role = Role::firstOrCreate(['name' => 'pemilik', 'guard_name' => 'web']);
            $user->assignRole($role);
        }

        return $user;
    }

    public function getRedirectUrl(): string
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $user?->load('usaha');

        if ($user && $user->usaha) {
            return filament()->getUrl(tenant: $user->usaha);
        }

        return filament()->getUrl();
    }
}
