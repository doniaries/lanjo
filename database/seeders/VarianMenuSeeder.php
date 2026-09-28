<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VarianMenu;

class VarianMenuSeeder extends Seeder
{
    public function run(): void
    {
        VarianMenu::insert([
            ['menu_id' => 1, 'nama_varian' => 'Pedas Sedang', 'harga_tambahan' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['menu_id' => 1, 'nama_varian' => 'Sangat Pedas', 'harga_tambahan' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['menu_id' => 1, 'nama_varian' => 'Tambah Telur Mata Sapi', 'harga_tambahan' => 5000, 'created_at' => now(), 'updated_at' => now()],
            
            ['menu_id' => 3, 'nama_varian' => 'Es Sedikit (Less Ice)', 'harga_tambahan' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['menu_id' => 3, 'nama_varian' => 'Gula Sedikit (Less Sugar)', 'harga_tambahan' => 0, 'created_at' => now(), 'updated_at' => now()],
            
            ['menu_id' => 4, 'nama_varian' => 'Panas', 'harga_tambahan' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['menu_id' => 4, 'nama_varian' => 'Dingin (Es)', 'harga_tambahan' => 2000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
