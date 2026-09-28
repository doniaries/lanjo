<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ShieldSeeder::class, // Roles & permissions
            UserSeeder::class,   // Users: superadmin, admin, member
        ]);
    }
}
