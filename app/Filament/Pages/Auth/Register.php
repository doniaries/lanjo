<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Auth\Pages\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getNameFormComponent()
                ->label('Nama Lengkap / Nama Instansi')
                ->placeholder('Contoh: Budi Santoso / Dinas Pariwisata'),
            $this->getEmailFormComponent()
                ->placeholder('contoh@email.com'),
            TextInput::make('kontak')
                ->label('Nomor WhatsApp / HP Anda')
                ->placeholder('+6281234567890 atau 081234567890')
                ->required()
                ->regex('/^\+?[0-9]{8,15}$/') // Allows optional + and 8-15 digits
                ->validationMessages([
                    'regex' => 'Nomor WhatsApp tidak valid. Gunakan format angka dan boleh diawali dengan + (misal: +62812... atau 0812...).',
                ]),

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
        ]);
    }

    protected function handleRegistration(array $data): Model
    {
        // Add default values for new Dinas users
        $data['is_active'] = false;

        $user = $this->getUserModel()::create($data);

        // Assign 'Dinas' role if it exists
        if (class_exists(Role::class)) {
            $role = Role::firstOrCreate(['name' => 'Dinas', 'guard_name' => 'web']);
            $user->assignRole($role);
        }

        return $user;
    }
}
