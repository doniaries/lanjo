<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Bersihkan tabel users & role assignments ──────────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ─── Super Admin (tidak terikat usaha manapun) ────────────────────
        // tipe = 'superadmin' → UsahaScope akan skip filter
        $superAdmin = User::create([
            'id'                => 1,
            'usaha_id'          => null,          // global — tidak terikat tenant
            'name'              => 'Super Admin',
            'email'             => 'superadmin@gmail.com',
            'password'          => Hash::make('@Iamsuperadmin'),
            'tipe'              => 'superadmin',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);
        $superAdmin->syncRoles(['super_admin']);

        $this->command->info('✅ Super Admin dibuat: superadmin@gmail.com | @Iamsuperadmin');
    }
}
