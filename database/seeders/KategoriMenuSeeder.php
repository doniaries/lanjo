<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriMenu;

class KategoriMenuSeeder extends Seeder
{
    public function run(): void
    {
        KategoriMenu::insert([
            ['nama' => 'Makanan Utama', 'urutan' => 1, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Minuman', 'urutan' => 2, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Snack / Cemilan', 'urutan' => 3, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Dessert', 'urutan' => 4, 'aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
