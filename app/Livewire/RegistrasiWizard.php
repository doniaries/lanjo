<?php

namespace App\Livewire;

use App\Models\Usaha;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class RegistrasiWizard extends Component
{
    // ─── Step ─────────────────────────────────────────────────────────────
    public int $step = 1;
    public int $totalSteps = 2;

    // ─── Step 1: Data Usaha ───────────────────────────────────────────────
    public string $nama_usaha    = '';
    public string $tipe_usaha    = 'restoran';
    public string $alamat        = '';
    public string $telepon_usaha = '';

    // ─── Step 2: Akun Pemilik ─────────────────────────────────────────────
    public string $name           = '';
    public string $email          = '';
    public string $password       = '';
    public string $password_confirmation = '';
    public string $kontak         = '';
    public string $tipe           = 'pemilik';

    // ─── Validasi per step ────────────────────────────────────────────────
    protected function rulesStep1(): array
    {
        return [
            'nama_usaha'    => ['required', 'string', 'min:3', 'max:100'],
            'tipe_usaha'    => ['required', 'in:restoran,katering,cafe'],
            'alamat'        => ['nullable', 'string', 'max:255'],
            'telepon_usaha' => ['nullable', 'string', 'max:20'],
        ];
    }

    protected function rulesStep2(): array
    {
        return [
            'name'                  => ['required', 'string', 'min:3', 'max:100'],
            'email'                 => ['required', 'email', 'unique:users,email'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'kontak'                => ['nullable', 'string', 'max:20'],
            'tipe'                  => ['required', 'in:pemilik,karyawan'],
        ];
    }

    protected $messages = [
        'nama_usaha.required'   => 'Nama usaha wajib diisi.',
        'nama_usaha.min'        => 'Nama usaha minimal 3 karakter.',
        'tipe_usaha.in'         => 'Tipe usaha tidak valid.',
        'name.required'         => 'Nama pengguna wajib diisi.',
        'email.required'        => 'Email wajib diisi.',
        'email.unique'          => 'Email sudah digunakan.',
        'password.required'     => 'Password wajib diisi.',
        'password.min'          => 'Password minimal 8 karakter.',
        'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        'tipe.in'               => 'Status pengguna tidak valid.',
    ];

    // ─── Navigasi ─────────────────────────────────────────────────────────

    public function nextStep(): void
    {
        if ($this->step === 1) {
            $this->validate($this->rulesStep1());
        }

        if ($this->step < $this->totalSteps) {
            $this->step++;
        }
    }

    public function prevStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    // ─── Submit Final ──────────────────────────────────────────────────────

    public function submit(): void
    {
        $this->validate($this->rulesStep2());

        DB::transaction(function () {
            // Buat tenant (usaha)
            $usaha = Usaha::create([
                'nama_usaha' => $this->nama_usaha,
                'slug'       => Str::slug($this->nama_usaha) . '-' . Str::random(4),
                'tipe_usaha' => $this->tipe_usaha,
                'alamat'     => $this->alamat ?: null,
                'telepon'    => $this->telepon_usaha ?: null,
                'is_active'  => true,
            ]);

            // Buat user pemilik
            $user = User::create([
                'usaha_id'  => $usaha->id,
                'name'      => $this->name,
                'email'     => $this->email,
                'password'  => Hash::make($this->password),
                'kontak'    => $this->kontak ?: null,
                'tipe'      => $this->tipe,
                'is_active' => true,
            ]);

            Auth::login($user);
        });

        session()->flash('success', 'Selamat datang! Usaha Anda berhasil didaftarkan.');
        $this->redirect(route('filament.admin.pages.dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.registrasi-wizard');
    }
}
