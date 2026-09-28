<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::insert([
            // ─── MAKANAN UTAMA (kategori_menu_id = 1) ─────────────────
            [
                'kategori_menu_id' => 1,
                'nama'             => 'Nasi Goreng Spesial',
                'harga_jual'       => 25000,
                'harga_modal'      => 15000,
                'gambar'           => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?q=80&w=800',
                'stok'             => null,
                'status_aktif'     => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'kategori_menu_id' => 1,
                'nama'             => 'Mie Goreng Jawa',
                'harga_jual'       => 20000,
                'harga_modal'      => 12000,
                'gambar'           => 'https://images.unsplash.com/photo-1612929633738-8fe44f7ec841?q=80&w=800',
                'stok'             => null,
                'status_aktif'     => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'kategori_menu_id' => 1,
                'nama'             => 'Ayam Bakar Madu',
                'harga_jual'       => 32000,
                'harga_modal'      => 20000,
                'gambar'           => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?q=80&w=800',
                'stok'             => null,
                'status_aktif'     => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'kategori_menu_id' => 1,
                'nama'             => 'Soto Ayam Lamongan',
                'harga_jual'       => 22000,
                'harga_modal'      => 13000,
                'gambar'           => 'https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?q=80&w=800',
                'stok'             => null,
                'status_aktif'     => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'kategori_menu_id' => 1,
                'nama'             => 'Gado-Gado Jakarta',
                'harga_jual'       => 18000,
                'harga_modal'      => 10000,
                'gambar'           => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?q=80&w=800',
                'stok'             => null,
                'status_aktif'     => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],

            // ─── MINUMAN (kategori_menu_id = 2) ───────────────────────
            [
                'kategori_menu_id' => 2,
                'nama'             => 'Es Teh Manis',
                'harga_jual'       => 5000,
                'harga_modal'      => 2000,
                'gambar'           => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?q=80&w=800',
                'stok'             => null,
                'status_aktif'     => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'kategori_menu_id' => 2,
                'nama'             => 'Kopi Hitam Arabica',
                'harga_jual'       => 15000,
                'harga_modal'      => 8000,
                'gambar'           => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=800',
                'stok'             => null,
                'status_aktif'     => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'kategori_menu_id' => 2,
                'nama'             => 'Jus Alpukat',
                'harga_jual'       => 18000,
                'harga_modal'      => 10000,
                'gambar'           => 'https://images.unsplash.com/photo-1623065422902-30a2d299bbe4?q=80&w=800',
                'stok'             => null,
                'status_aktif'     => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'kategori_menu_id' => 2,
                'nama'             => 'Es Jeruk Peras',
                'harga_jual'       => 10000,
                'harga_modal'      => 5000,
                'gambar'           => 'https://images.unsplash.com/photo-1534353436294-0dbd4bdac845?q=80&w=800',
                'stok'             => null,
                'status_aktif'     => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],

            // ─── SNACK / CEMILAN (kategori_menu_id = 3) ───────────────
            [
                'kategori_menu_id' => 3,
                'nama'             => 'Pisang Goreng Crispy',
                'harga_jual'       => 12000,
                'harga_modal'      => 6000,
                'gambar'           => 'https://images.unsplash.com/photo-1562059390-a761a084768e?q=80&w=800',
                'stok'             => null,
                'status_aktif'     => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'kategori_menu_id' => 3,
                'nama'             => 'Kentang Goreng',
                'harga_jual'       => 15000,
                'harga_modal'      => 7000,
                'gambar'           => 'https://images.unsplash.com/photo-1630384060421-cb20d0e0649d?q=80&w=800',
                'stok'             => null,
                'status_aktif'     => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],

            // ─── DESSERT (kategori_menu_id = 4) ───────────────────────
            [
                'kategori_menu_id' => 4,
                'nama'             => 'Es Krim Vanilla',
                'harga_jual'       => 15000,
                'harga_modal'      => 7000,
                'gambar'           => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?q=80&w=800',
                'stok'             => null,
                'status_aktif'     => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
        ]);
    }
}
