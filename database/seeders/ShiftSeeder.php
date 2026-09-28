<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shift;
use Carbon\Carbon;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();

        // 1. Shift Pagi (07:00 - 16:00)
        // Budi (ID 4) & Siti (ID 5)
        Shift::create([
            'pengguna_id' => 4, // Budi
            'waktu_mulai' => $today->copy()->setTime(7, 0, 0),
            'waktu_selesai' => $today->copy()->setTime(16, 0, 0),
            'kas_awal' => 500000,
            'kas_akhir' => 2000000,
            'status' => 'tutup',
        ]);
        Shift::create([
            'pengguna_id' => 5, // Siti
            'waktu_mulai' => $today->copy()->setTime(7, 0, 0),
            'waktu_selesai' => $today->copy()->setTime(16, 0, 0),
            'kas_awal' => 500000,
            'kas_akhir' => 1500000,
            'status' => 'tutup',
        ]);

        // 2. Shift Malam (16:00 - 22:00)
        // Agus (ID 6) & Dewi (ID 7)
        Shift::create([
            'pengguna_id' => 6, // Agus
            'waktu_mulai' => $today->copy()->setTime(16, 0, 0),
            'waktu_selesai' => $today->copy()->setTime(22, 0, 0),
            'kas_awal' => 2000000,
            'kas_akhir' => 3500000,
            'status' => 'tutup',
        ]);
        Shift::create([
            'pengguna_id' => 7, // Dewi
            'waktu_mulai' => $today->copy()->setTime(16, 0, 0),
            'waktu_selesai' => null, // Masih berlangsung
            'kas_awal' => 1500000,
            'kas_akhir' => 0,
            'status' => 'buka',
        ]);
    }
}
