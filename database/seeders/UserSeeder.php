<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ================================================================
        // STARTER PACK — USER SEEDER
        // 3 Role: super_admin | admin | karyawan
        //
        // Ganti credential ini sebelum deploy ke production!
        // ================================================================

        // Nonaktifkan foreign key sementara agar truncate aman
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ────────────────────────────────────────────────────────────────
        // 1. SUPER ADMIN
        //    Akses penuh ke seluruh sistem via Gate::before di AppServiceProvider
        //    Email  : superadmin@gmail.com
        //    Password: @Iamsuperadmin
        // ────────────────────────────────────────────────────────────────
        $superAdmin = User::create([
            'id'                => 1,
            'name'              => 'Super Admin',
            'email'             => 'superadmin@gmail.com',
            'password'          => Hash::make('@Iamsuperadmin'),
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $superAdmin->syncRoles(['super_admin']);

        // ────────────────────────────────────────────────────────────────
        // 2. ADMIN
        //    Kelola semua konten & user, kecuali hapus role/pengaturan sensitif
        //    Email  : admin@local.com
        //    Password: Admin@123
        // ────────────────────────────────────────────────────────────────
        $admin = User::create([
            'name'              => 'Administrator',
            'email'             => 'admin@local.com',
            'password'          => Hash::make('Admin@123'),
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $admin->syncRoles(['admin']);

        // ────────────────────────────────────────────────────────────────
        // 3. KARYAWAN
        //    Akses terbatas: hanya dashboard & profil sendiri
        //    Email  : karyawan@local.com
        //    Password: Karyawan@123
        // ────────────────────────────────────────────────────────────────
        $karyawan = User::create([
            'name'              => 'Karyawan',
            'email'             => 'karyawan@local.com',
            'password'          => Hash::make('Karyawan@123'),
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $karyawan->syncRoles(['karyawan']);

        // ────────────────────────────────────────────────────────────────
        // 4. KARYAWAN (4 Orang)
        // ────────────────────────────────────────────────────────────────
        $karyawan1 = User::create([
            'name'              => 'Budi (Karyawan)',
            'email'             => 'budi@local.com',
            'password'          => Hash::make('Karyawan@123'),
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $karyawan1->syncRoles(['karyawan']);

        $karyawan2 = User::create([
            'name'              => 'Siti (Karyawan)',
            'email'             => 'siti@local.com',
            'password'          => Hash::make('Karyawan@123'),
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $karyawan2->syncRoles(['karyawan']);

        $karyawan3 = User::create([
            'name'              => 'Agus (Karyawan)',
            'email'             => 'agus@local.com',
            'password'          => Hash::make('Karyawan@123'),
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $karyawan3->syncRoles(['karyawan']);

        $karyawan4 = User::create([
            'name'              => 'Dewi (Karyawan)',
            'email'             => 'dewi@local.com',
            'password'          => Hash::make('Karyawan@123'),
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $karyawan4->syncRoles(['karyawan']);

        // ────────────────────────────────────────────────────────────────
        // INFO SUMMARY
        // ────────────────────────────────────────────────────────────────
        $this->command->newLine();
        $this->command->info('✅ User Seeding Completed!');
        $this->command->newLine();
        $this->command->table(
            ['#', 'Nama', 'Email', 'Role', 'Password'],
            [
                [1, 'Super Admin',   'superadmin@gmail.com', 'super_admin', '@Iamsuperadmin'],
                [2, 'Administrator', 'admin@local.com',      'admin',       'Admin@123'],
                [3, 'Karyawan',        'karyawan@local.com',     'karyawan',      'Karyawan@123'],
                [4, 'Budi',          'budi@local.com',       'karyawan',      'Karyawan@123'],
                [5, 'Siti',          'siti@local.com',       'karyawan',      'Karyawan@123'],
                [6, 'Agus',          'agus@local.com',       'karyawan',      'Karyawan@123'],
                [7, 'Dewi',          'dewi@local.com',       'karyawan',      'Karyawan@123'],
            ]
        );
        $this->command->newLine();
        $this->command->warn('⚠️  Jangan lupa ganti credential sebelum deploy ke production!');
    }
}
