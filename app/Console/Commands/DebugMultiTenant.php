<?php

namespace App\Console\Commands;

use App\Models\KategoriMenu;
use App\Models\Meja;
use App\Models\Pengaturan;
use App\Models\Usaha;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DebugMultiTenant extends Command
{
    protected $signature   = 'debug:multitenant';
    protected $description = 'Debug test isolasi data multi-tenant dan simulasi registrasi wizard';

    public function handle(): int
    {
        $this->line('');
        $this->line('═══════════════════════════════════════════════════════');
        $this->info('  DEBUG TEST: Multi-Tenant e-Trans');
        $this->line('═══════════════════════════════════════════════════════');

        $pass = 0;
        $fail = 0;

        // ─── TEST 1: Jumlah Usaha ─────────────────────────────────────────
        $this->line('');
        $this->line('─── TEST 1: Verifikasi Data Usaha ─────────────────────');
        $usahas = Usaha::withoutGlobalScopes()->get();
        $this->line("Usaha ditemukan: {$usahas->count()}");
        foreach ($usahas as $u) {
            $this->line("  • [{$u->id}] {$u->nama_usaha} | {$u->tipe_usaha}");
        }
        if ($usahas->count() === 2) {
            $this->info('  ✅ PASS: 2 usaha tersedia'); $pass++;
        } else {
            $this->error('  ❌ FAIL: Jumlah usaha tidak sesuai'); $fail++;
        }

        // ─── TEST 2: Jumlah User ──────────────────────────────────────────
        $this->line('');
        $this->line('─── TEST 2: Verifikasi Total User ──────────────────────');
        $totalUser = User::withoutGlobalScopes()->count();
        $this->line("Total user: {$totalUser} (expected: 6)");
        if ($totalUser === 6) {
            $this->info('  ✅ PASS'); $pass++;
        } else {
            $this->error('  ❌ FAIL'); $fail++;
        }

        // ─── TEST 3: Isolasi Usaha 1 ──────────────────────────────────────
        $this->line('');
        $this->line('─── TEST 3: Isolasi Data — Warung Pak Budi ────────────');
        $u1 = User::withoutGlobalScopes()->where('email', 'pemilik@warungpakbudi.com')->first();
        if (! $u1) {
            $this->error('  ❌ FAIL: User pemilik@warungpakbudi.com tidak ditemukan'); $fail++;
        } else {
            Auth::login($u1);
            $km = KategoriMenu::count();
            $mj = Meja::count();
            $pg = Pengaturan::count();
            $this->line("  Login: {$u1->name} (usaha_id: {$u1->usaha_id})");
            $this->line("  KategoriMenu: {$km} (exp 4) | Meja: {$mj} (exp 6) | Pengaturan: {$pg} (exp 1)");
            Auth::logout();

            if ($km === 4 && $mj === 6 && $pg === 1) {
                $this->info('  ✅ PASS: Isolasi data benar'); $pass++;
            } else {
                $this->error('  ❌ FAIL: Data bocor ke tenant lain!'); $fail++;
            }
        }

        // ─── TEST 4: Isolasi Usaha 2 ──────────────────────────────────────
        $this->line('');
        $this->line('─── TEST 4: Isolasi Data — Cafe Senja ─────────────────');
        $u2 = User::withoutGlobalScopes()->where('email', 'pemilik@cafesenja.com')->first();
        if (! $u2) {
            $this->error('  ❌ FAIL: User pemilik@cafesenja.com tidak ditemukan'); $fail++;
        } else {
            Auth::login($u2);
            $km2 = KategoriMenu::count();
            $mj2 = Meja::count();
            $pg2 = Pengaturan::count();
            $this->line("  Login: {$u2->name} (usaha_id: {$u2->usaha_id})");
            $this->line("  KategoriMenu: {$km2} (exp 4) | Meja: {$mj2} (exp 4) | Pengaturan: {$pg2} (exp 1)");
            Auth::logout();

            if ($km2 === 4 && $mj2 === 4 && $pg2 === 1) {
                $this->info('  ✅ PASS: Isolasi data benar'); $pass++;
            } else {
                $this->error('  ❌ FAIL: Data bocor ke tenant lain!'); $fail++;
            }
        }

        // ─── TEST 5: Superadmin Lihat Semua ───────────────────────────────
        $this->line('');
        $this->line('─── TEST 5: Superadmin — Lihat Semua Data ─────────────');
        $sa = User::withoutGlobalScopes()->where('email', 'superadmin@gmail.com')->first();
        if (! $sa) {
            $this->error('  ❌ FAIL: SuperAdmin tidak ditemukan'); $fail++;
        } else {
            Auth::login($sa);
            $allKm = KategoriMenu::count();
            $allMj = Meja::count();
            $allPg = Pengaturan::count();
            $this->line("  Login: {$sa->name} (tipe: {$sa->tipe})");
            $this->line("  KategoriMenu: {$allKm} (exp 8) | Meja: {$allMj} (exp 10) | Pengaturan: {$allPg} (exp 2)");
            Auth::logout();

            if ($allKm === 8 && $allMj === 10 && $allPg === 2) {
                $this->info('  ✅ PASS: Superadmin bisa lihat semua'); $pass++;
            } else {
                $this->error('  ❌ FAIL: Superadmin seharusnya lihat semua data'); $fail++;
            }
        }

        // ─── TEST 6: Simulasi Registrasi Wizard ───────────────────────────
        $this->line('');
        $this->line('─── TEST 6: Simulasi Registrasi Wizard ─────────────────');
        DB::beginTransaction();
        try {
            $newUsaha = Usaha::create([
                'nama_usaha' => 'Test Usaha Registrasi',
                'slug'       => 'test-usaha-' . Str::random(4),
                'tipe_usaha' => 'restoran',
                'is_active'  => true,
            ]);

            $newUser = User::create([
                'usaha_id'  => $newUsaha->id,
                'name'      => 'Test Pemilik',
                'email'     => 'testpemilik' . time() . '@test.com',
                'password'  => Hash::make('Test@12345'),
                'tipe'      => 'pemilik',
                'is_active' => true,
            ]);

            $this->line("  Usaha dibuat: {$newUsaha->nama_usaha} (id: {$newUsaha->id})");
            $this->line("  User dibuat: {$newUser->name} → usaha: {$newUser->usaha->nama_usaha}");

            // Verifikasi relasi dua arah
            $userDariUsaha = $newUsaha->users()->first();
            $this->line("  Relasi usaha→user: {$userDariUsaha->name}");

            DB::rollBack();
            $this->info('  ✅ PASS: Registrasi wizard simulation berhasil (di-rollback)'); $pass++;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('  ❌ FAIL: ' . $e->getMessage()); $fail++;
        }

        // ─── TEST 7: Cek Route Registrasi ─────────────────────────────────
        $this->line('');
        $this->line('─── TEST 7: Route /daftar ───────────────────────────────');
        try {
            $url = route('registrasi');
            $this->line("  URL: {$url}");
            $this->info('  ✅ PASS: Route registrasi terdaftar'); $pass++;
        } catch (\Throwable $e) {
            $this->error('  ❌ FAIL: Route tidak ditemukan'); $fail++;
        }

        // ─── SUMMARY ──────────────────────────────────────────────────────
        $this->line('');
        $this->line('═══════════════════════════════════════════════════════');
        $total = $pass + $fail;
        if ($fail === 0) {
            $this->info("  ✅ SEMUA TEST LULUS: {$pass}/{$total}");
        } else {
            $this->warn("  ⚠️  HASIL: {$pass} lulus, {$fail} gagal dari {$total} test");
        }
        $this->line('═══════════════════════════════════════════════════════');
        $this->line('');

        return $fail === 0 ? self::SUCCESS : self::FAILURE;
    }
}
