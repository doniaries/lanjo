<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::insert([
            [
                'kategori_menu_id' => 1, // Makanan Utama
                'nama' => 'Nasi Goreng Spesial',
                'harga_jual' => 25000,
                'harga_modal' => 15000,
                'gambar' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?q=80&w=800',
                'stok' => 50,
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kategori_menu_id' => 1, // Makanan Utama
                'nama' => 'Mie Goreng Jawa',
                'harga_jual' => 20000,
                'harga_modal' => 12000,
                'gambar' => 'https://images.unsplash.com/photo-1612929633738-8fe44f7ec841?q=80&w=800',
                'stok' => 40,
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kategori_menu_id' => 2, // Minuman
                'nama' => 'Es Teh Manis',
                'harga_jual' => 5000,
                'harga_modal' => 2000,
                'gambar' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?q=80&w=800',
                'stok' => 100,
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kategori_menu_id' => 2, // Minuman
                'nama' => 'Kopi Hitam Arabica',
                'harga_jual' => 15000,
                'harga_modal' => 8000,
                'gambar' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=800',
                'stok' => 80,
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
