<?php
/**
 * Debug Test: Multi-Tenant Isolation & Registrasi
 * Jalankan: php artisan tinker < debug_multitenant.php
 */

use App\Models\KategoriMenu;
use App\Models\Meja;
use App\Models\Pengaturan;
use App\Models\Usaha;
use App\Models\User;

echo "\n";
echo "═══════════════════════════════════════════════════════\n";
echo "  DEBUG TEST: Multi-Tenant e-Trans\n";
echo "═══════════════════════════════════════════════════════\n\n";

// ─── TEST 1: Verifikasi struktur database ────────────────────────────────────
echo "─── TEST 1: Verifikasi Data Usaha ─────────────────────\n";
$usahas = Usaha::withoutGlobalScopes()->get();
echo "Jumlah usaha: " . $usahas->count() . " (expected: 2)\n";
foreach ($usahas as $u) {
    echo "  • [{$u->id}] {$u->nama_usaha} | tipe: {$u->tipe_usaha} | aktif: " . ($u->is_active ? 'ya' : 'tidak') . "\n";
}

echo "\n─── TEST 2: Verifikasi User per Usaha ─────────────────\n";
$users = User::withoutGlobalScopes()->get();
echo "Total user: " . $users->count() . " (expected: 6 → 1 superadmin + 5 tenant)\n";
foreach ($users as $u) {
    $usahaNama = $u->usaha_id ? Usaha::find($u->usaha_id)?->nama_usaha : 'GLOBAL';
    echo "  • [{$u->tipe}] {$u->name} → usaha: {$usahaNama}\n";
}

echo "\n─── TEST 3: Isolasi Data — Simulasi Login Usaha 1 ──────\n";
$pemilik1 = User::withoutGlobalScopes()->where('email', 'pemilik@warungpakbudi.com')->first();
if ($pemilik1) {
    Auth::login($pemilik1);
    echo "Login sebagai: {$pemilik1->name} (usaha_id: {$pemilik1->usaha_id})\n";

    $kategoris = KategoriMenu::all();
    echo "KategoriMenu terlihat: " . $kategoris->count() . " (expected: 4 — hanya punya Warung Pak Budi)\n";

    $mejas = Meja::all();
    echo "Meja terlihat: " . $mejas->count() . " (expected: 6 — hanya punya Warung Pak Budi)\n";

    $pengaturan = Pengaturan::all();
    echo "Pengaturan terlihat: " . $pengaturan->count() . " (expected: 1)\n";

    Auth::logout();
    echo "Logout ✓\n";
} else {
    echo "❌ Pemilik1 tidak ditemukan!\n";
}

echo "\n─── TEST 4: Isolasi Data — Simulasi Login Usaha 2 ──────\n";
$pemilik2 = User::withoutGlobalScopes()->where('email', 'pemilik@cafesenja.com')->first();
if ($pemilik2) {
    Auth::login($pemilik2);
    echo "Login sebagai: {$pemilik2->name} (usaha_id: {$pemilik2->usaha_id})\n";

    $kategoris2 = KategoriMenu::all();
    echo "KategoriMenu terlihat: " . $kategoris2->count() . " (expected: 4 — hanya punya Cafe Senja)\n";

    $mejas2 = Meja::all();
    echo "Meja terlihat: " . $mejas2->count() . " (expected: 4 — hanya punya Cafe Senja)\n";

    Auth::logout();
    echo "Logout ✓\n";
} else {
    echo "❌ Pemilik2 tidak ditemukan!\n";
}

echo "\n─── TEST 5: Superadmin — Bisa Lihat Semua ───────────────\n";
$superAdmin = User::withoutGlobalScopes()->where('email', 'superadmin@gmail.com')->first();
if ($superAdmin) {
    Auth::login($superAdmin);
    echo "Login sebagai: {$superAdmin->name} (tipe: {$superAdmin->tipe})\n";

    $allKategoris = KategoriMenu::all();
    echo "KategoriMenu terlihat: " . $allKategoris->count() . " (expected: 8 — semua usaha)\n";

    $allMejas = Meja::all();
    echo "Meja terlihat: " . $allMejas->count() . " (expected: 10 — semua usaha)\n";

    Auth::logout();
    echo "Logout ✓\n";
} else {
    echo "❌ SuperAdmin tidak ditemukan!\n";
}

echo "\n─── TEST 6: Simulasi Registrasi Wizard ──────────────────\n";
// Simulasi apa yang dilakukan RegistrasiWizard::submit()
DB::beginTransaction();
try {
    $slugBase = Str::slug('Test Usaha Baru');
    $newUsaha = Usaha::create([
        'nama_usaha' => 'Test Usaha Baru',
        'slug'       => $slugBase . '-' . Str::random(4),
        'tipe_usaha' => 'restoran',
        'alamat'     => 'Jl. Test No. 1',
        'telepon'    => '089999999999',
        'is_active'  => true,
    ]);
    echo "Usaha baru dibuat: {$newUsaha->nama_usaha} (id: {$newUsaha->id})\n";

    $newUser = User::create([
        'usaha_id'  => $newUsaha->id,
        'name'      => 'Test Pemilik Baru',
        'email'     => 'test_registrasi_' . time() . '@test.com',
        'password'  => Hash::make('Test@12345'),
        'kontak'    => '089999999999',
        'tipe'      => 'pemilik',
        'is_active' => true,
    ]);
    echo "User baru dibuat: {$newUser->name} → usaha_id: {$newUser->usaha_id}\n";
    echo "Relasi usaha: " . $newUser->usaha->nama_usaha . "\n";

    DB::rollBack(); // Rollback agar tidak kotor database
    echo "✅ Registrasi wizard simulation BERHASIL (di-rollback)\n";
} catch (\Exception $e) {
    DB::rollBack();
    echo "❌ GAGAL: " . $e->getMessage() . "\n";
}

echo "\n─── TEST 7: Route Registrasi ────────────────────────────\n";
$route = route('registrasi');
echo "URL Registrasi: {$route}\n";

$routeMiddleware = collect(app('router')->getRoutes())
    ->filter(fn($r) => $r->getName() === 'registrasi')
    ->first();

if ($routeMiddleware) {
    echo "Middleware: " . implode(', ', $routeMiddleware->middleware()) . "\n";
    echo "✅ Route /daftar terdaftar dengan benar\n";
} else {
    echo "❌ Route registrasi tidak ditemukan!\n";
}

echo "\n═══════════════════════════════════════════════════════\n";
echo "  HASIL: Semua test selesai\n";
echo "═══════════════════════════════════════════════════════\n\n";
