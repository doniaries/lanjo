<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usaha;
use App\Models\User;
use App\Models\Menu;
use App\Models\Meja;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DummyPesananSeeder extends Seeder
{
    public function run(): void
    {
        $usaha = Usaha::first();
        if (!$usaha) {
            $this->command->warn('Tidak ada data Usaha. Silakan buat Usaha terlebih dahulu.');
            return;
        }

        // Hapus data dummy lama agar tidak menumpuk saat di run berulang
        Pesanan::where('catatan', 'Dummy seeder data')->delete();

        $kasir = User::whereHas('roles', function($q) {
            $q->where('name', 'kasir');
        })->first() ?? User::first();

        $menus = Menu::where('usaha_id', $usaha->id)->get();
        if ($menus->isEmpty()) {
            $this->command->warn('Tidak ada data Menu pada Usaha pertama. Silakan buat Menu terlebih dahulu.');
            return;
        }

        $mejas = Meja::where('usaha_id', $usaha->id)->get();
        $mejaId = $mejas->isNotEmpty() ? $mejas->first()->id : null;

        $dates = [
            // Hari Ini
            Carbon::today()->addHours(10),
            Carbon::today()->addHours(12),
            Carbon::today()->addHours(14),
            Carbon::today()->addHours(18),
            
            // Kemarin
            Carbon::yesterday()->addHours(11),
            Carbon::yesterday()->addHours(13),
            Carbon::yesterday()->addHours(19),

            // Minggu Ini (2 hari lalu)
            Carbon::today()->subDays(2)->addHours(12),
            Carbon::today()->subDays(3)->addHours(15),

            // Bulan Ini (10 hari lalu)
            Carbon::today()->subDays(10)->addHours(14),
            Carbon::today()->subDays(15)->addHours(16),
        ];

        foreach ($dates as $index => $date) {
            $pesanan = Pesanan::create([
                'usaha_id' => $usaha->id,
                'kasir_id' => $kasir->id,
                'meja_id' => $mejaId,
                'nomor_nota' => 'INV-' . $date->format('Ymd') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT) . '-' . Str::random(4),
                'tanggal' => $date,
                'tipe_pesanan' => 'dine_in',
                'status' => 'selesai',
                'subtotal' => 0,
                'pajak_nilai' => 0,
                'diskon_nilai' => 0,
                'total_akhir' => 0,
                'catatan' => 'Dummy seeder data',
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            $total = 0;
            $itemsCount = rand(1, 3);
            for ($i = 0; $i < $itemsCount; $i++) {
                $menu = $menus->random();
                $qty = rand(1, 4);
                $sub = $menu->harga_jual * $qty;
                
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'menu_id' => $menu->id,
                    'nama_menu_snapshot' => $menu->nama,
                    'harga_satuan_snapshot' => $menu->harga_jual,
                    'jumlah' => $qty,
                    'subtotal' => $sub,
                ]);

                $total += $sub;
            }

            $pesanan->update([
                'subtotal' => $total,
                'total_akhir' => $total,
            ]);

            Pembayaran::create([
                'pesanan_id' => $pesanan->id,
                'kasir_id' => $kasir->id,
                'jumlah_bayar' => $total,
                'kembalian' => 0,
                'metode' => 'tunai',
                'waktu_bayar' => $date,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        $this->command->info('Berhasil membuat 11 data transaksi dummy (Hari ini, Kemarin, Minggu ini, Bulan ini).');
    }
}
