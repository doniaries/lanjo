<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $usahas = \App\Models\Usaha::all();

        if ($usahas->isEmpty()) {
            $this->command->warn('Tidak ada data Usaha. Silakan buat Usaha terlebih dahulu.');
            return;
        }

        foreach ($usahas as $usaha) {
            // 1. Buat Kategori Menu untuk setiap usaha
            $katMakanan = \App\Models\KategoriMenu::firstOrCreate([
                'usaha_id' => $usaha->id,
                'nama' => 'Makanan Utama',
            ]);
            $katMinuman = \App\Models\KategoriMenu::firstOrCreate([
                'usaha_id' => $usaha->id,
                'nama' => 'Minuman',
            ]);
            $katSnack = \App\Models\KategoriMenu::firstOrCreate([
                'usaha_id' => $usaha->id,
                'nama' => 'Snack / Cemilan',
            ]);

            // 2. Insert Menu untuk usaha ini
            Menu::insert([
                // ─── MAKANAN UTAMA ─────────────────
                [
                    'usaha_id'         => $usaha->id,
                    'kategori_menu_id' => $katMakanan->id,
                    'nama'             => 'Nasi Goreng Spesial ' . $usaha->nama_usaha,
                    'harga_jual'       => 25000,
                    'harga_modal'      => 15000,
                    'gambar'           => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?q=80&w=800',
                    'stok'             => null,
                    'status_aktif'     => true,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ],
                [
                    'usaha_id'         => $usaha->id,
                    'kategori_menu_id' => $katMakanan->id,
                    'nama'             => 'Mie Goreng Jawa ' . $usaha->nama_usaha,
                    'harga_jual'       => 20000,
                    'harga_modal'      => 12000,
                    'gambar'           => 'https://images.unsplash.com/photo-1612929633738-8fe44f7ec841?q=80&w=800',
                    'stok'             => null,
                    'status_aktif'     => true,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ],
                // ─── MINUMAN ───────────────────────
                [
                    'usaha_id'         => $usaha->id,
                    'kategori_menu_id' => $katMinuman->id,
                    'nama'             => 'Es Teh Manis ' . $usaha->nama_usaha,
                    'harga_jual'       => 5000,
                    'harga_modal'      => 2000,
                    'gambar'           => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?q=80&w=800',
                    'stok'             => null,
                    'status_aktif'     => true,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ],
                [
                    'usaha_id'         => $usaha->id,
                    'kategori_menu_id' => $katMinuman->id,
                    'nama'             => 'Kopi Hitam Arabica ' . $usaha->nama_usaha,
                    'harga_jual'       => 15000,
                    'harga_modal'      => 8000,
                    'gambar'           => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=800',
                    'stok'             => null,
                    'status_aktif'     => true,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ],
                // ─── SNACK / CEMILAN ───────────────
                [
                    'usaha_id'         => $usaha->id,
                    'kategori_menu_id' => $katSnack->id,
                    'nama'             => 'Kentang Goreng ' . $usaha->nama_usaha,
                    'harga_jual'       => 15000,
                    'harga_modal'      => 7000,
                    'gambar'           => 'https://images.unsplash.com/photo-1630384060421-cb20d0e0649d?q=80&w=800',
                    'stok'             => null,
                    'status_aktif'     => true,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ],
            ]);
        }
    }
}
