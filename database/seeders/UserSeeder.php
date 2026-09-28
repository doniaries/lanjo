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
        // 3 Role: super_admin | admin | member
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
        // 3. MEMBER
        //    Akses terbatas: hanya dashboard & profil sendiri
        //    Email  : member@local.com
        //    Password: Member@123
        // ────────────────────────────────────────────────────────────────
        $member = User::create([
            'name'              => 'Member',
            'email'             => 'member@local.com',
            'password'          => Hash::make('Member@123'),
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $member->syncRoles(['member']);

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
                [3, 'Member',        'member@local.com',     'member',      'Member@123'],
            ]
        );
        $this->command->newLine();
        $this->command->warn('⚠️  Jangan lupa ganti credential sebelum deploy ke production!');
    }
}
