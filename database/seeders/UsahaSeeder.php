<?php

namespace Database\Seeders;

use App\Models\KategoriMenu;
use App\Models\Meja;
use App\Models\Pengaturan;
use App\Models\Usaha;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsahaSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Buat 2 Usaha Demo ─────────────────────────────────────────────

        $usaha1 = Usaha::create([
            'nama_usaha'    => 'Warung Pak Budi',
            'slug'          => 'warung-pak-budi',
            'alamat'        => 'Jl. Jenderal Sudirman No. 123, Jakarta',
            'telepon'       => '081234567890',
            'tipe_usaha'    => 'restoran',
            'pajak_default' => 11.00,
            'pajak_aktif'   => true,
            'is_active'     => true,
        ]);

        $usaha2 = Usaha::create([
            'nama_usaha'    => 'Cafe Senja',
            'slug'          => 'cafe-senja',
            'alamat'        => 'Jl. Gatot Subroto No. 45, Bandung',
            'telepon'       => '082234567891',
            'tipe_usaha'    => 'cafe',
            'pajak_default' => 10.00,
            'pajak_aktif'   => false,
            'is_active'     => true,
        ]);

        // ─── Buat User per Usaha ───────────────────────────────────────────

        // Pemilik Usaha 1
        $pemilik1 = User::create([
            'usaha_id'          => $usaha1->id,
            'name'              => 'Budi Santoso',
            'email'             => 'pemilik@warungpakbudi.com',
            'password'          => Hash::make('Pemilik@123'),
            'kontak'            => '081234567890',
            'tipe'              => 'pemilik',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $pemilik1->syncRoles(['admin']);

        // Karyawan Usaha 1
        $karyawan1a = User::create([
            'usaha_id'          => $usaha1->id,
            'name'              => 'Siti Karyawan',
            'email'             => 'siti@warungpakbudi.com',
            'password'          => Hash::make('Karyawan@123'),
            'kontak'            => '082234567892',
            'tipe'              => 'karyawan',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $karyawan1a->syncRoles(['member']);

        $karyawan1b = User::create([
            'usaha_id'          => $usaha1->id,
            'name'              => 'Agus Karyawan',
            'email'             => 'agus@warungpakbudi.com',
            'password'          => Hash::make('Karyawan@123'),
            'kontak'            => '083234567893',
            'tipe'              => 'karyawan',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $karyawan1b->syncRoles(['member']);

        // Pemilik Usaha 2
        $pemilik2 = User::create([
            'usaha_id'          => $usaha2->id,
            'name'              => 'Dewi Rahayu',
            'email'             => 'pemilik@cafesenja.com',
            'password'          => Hash::make('Pemilik@123'),
            'kontak'            => '084234567894',
            'tipe'              => 'pemilik',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $pemilik2->syncRoles(['admin']);

        // Karyawan Usaha 2
        $karyawan2a = User::create([
            'usaha_id'          => $usaha2->id,
            'name'              => 'Rina Barista',
            'email'             => 'rina@cafesenja.com',
            'password'          => Hash::make('Karyawan@123'),
            'kontak'            => '085234567895',
            'tipe'              => 'karyawan',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $karyawan2a->syncRoles(['member']);

        // ─── Pengaturan per Usaha ──────────────────────────────────────────
        // Dibuat tanpa BelongsToUsaha scope (scope butuh auth, seeder tidak login)
        Pengaturan::withoutGlobalScopes()->create([
            'usaha_id'      => $usaha1->id,
            'nama_toko'     => $usaha1->nama_usaha,
            'nama_pimpinan' => 'Budi Santoso',
            'alamat'        => $usaha1->alamat,
            'telepon'       => $usaha1->telepon,
            'tipe_toko'     => 'restoran',
            'pajak_default' => 11.00,
            'logo'          => null,
        ]);

        Pengaturan::withoutGlobalScopes()->create([
            'usaha_id'      => $usaha2->id,
            'nama_toko'     => $usaha2->nama_usaha,
            'nama_pimpinan' => 'Dewi Rahayu',
            'alamat'        => $usaha2->alamat,
            'telepon'       => $usaha2->telepon,
            'tipe_toko'     => 'restoran',  // enum lama hanya: restoran|katering
            'pajak_default' => 10.00,
            'logo'          => null,
        ]);

        // ─── Kategori Menu per Usaha ───────────────────────────────────────
        $kategoris = [
            ['nama' => 'Makanan Utama', 'urutan' => 1, 'aktif' => true],
            ['nama' => 'Minuman',       'urutan' => 2, 'aktif' => true],
            ['nama' => 'Snack',         'urutan' => 3, 'aktif' => true],
            ['nama' => 'Dessert',       'urutan' => 4, 'aktif' => true],
        ];

        foreach ($kategoris as $kat) {
            KategoriMenu::withoutGlobalScopes()->create(array_merge($kat, ['usaha_id' => $usaha1->id]));
            KategoriMenu::withoutGlobalScopes()->create(array_merge($kat, ['usaha_id' => $usaha2->id]));
        }

        // ─── Meja per Usaha ────────────────────────────────────────────────
        for ($i = 1; $i <= 6; $i++) {
            Meja::withoutGlobalScopes()->create([
                'usaha_id'   => $usaha1->id,
                'nomor_meja' => 'W-' . $i,
                'status'     => 'kosong',
            ]);
        }
        for ($i = 1; $i <= 4; $i++) {
            Meja::withoutGlobalScopes()->create([
                'usaha_id'   => $usaha2->id,
                'nomor_meja' => 'C-' . $i,
                'status'     => 'kosong',
            ]);
        }

        // ─── Output Summary ────────────────────────────────────────────────
        $this->command->newLine();
        $this->command->info('✅ Usaha Seeding Selesai!');
        $this->command->newLine();
        $this->command->table(
            ['Usaha', 'Email', 'Tipe', 'Password'],
            [
                [$usaha1->nama_usaha, 'pemilik@warungpakbudi.com', 'pemilik', 'Pemilik@123'],
                [$usaha1->nama_usaha, 'siti@warungpakbudi.com',    'karyawan', 'Karyawan@123'],
                [$usaha1->nama_usaha, 'agus@warungpakbudi.com',    'karyawan', 'Karyawan@123'],
                [$usaha2->nama_usaha, 'pemilik@cafesenja.com',     'pemilik', 'Pemilik@123'],
                [$usaha2->nama_usaha, 'rina@cafesenja.com',        'karyawan', 'Karyawan@123'],
            ]
        );
    }
}
