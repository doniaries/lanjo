<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ShieldSeeder::class,      // 1. Roles & permissions (harus pertama)
            SuperAdminSeeder::class,  // 2. Super admin (tidak terikat usaha)
            UsahaSeeder::class,       // 3. Usaha + user + data per tenant
        ]);
    }
}
