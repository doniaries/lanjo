<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaturan;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        Pengaturan::create([
            'nama_toko' => 'E-Trans Resto & Cafe',
            'alamat' => 'Jl. Jenderal Sudirman No. 123, Jakarta',
            'telepon' => '081234567890',
            'tipe_toko' => 'restoran',
            'pajak_default' => 11.00,
            'logo' => null,
        ]);
    }
}
