<?php

namespace Database\Seeders;

use App\Models\Meja;
use Illuminate\Database\Seeder;

class MejaSeeder extends Seeder
{
    public function run(): void
    {
        $mejas = [];
        for ($i = 1; $i <= 6; $i++) {
            $mejas[] = [
                'nomor_meja' => (string) $i,
                'status' => 'kosong',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Meja::insert($mejas);
    }
}
