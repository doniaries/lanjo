<?php

use App\Livewire\Kasir\PosPage;
use App\Livewire\Kasir\RiwayatPage;
use App\Livewire\RegistrasiWizard;
use Illuminate\Support\Facades\Route;

// ─── Registrasi Usaha (multi-tenant) ──────────────────────────────────────────
Route::get('/daftar', RegistrasiWizard::class)
    ->middleware('guest')
    ->name('registrasi');


Route::get('/', function () {
    return redirect('/admin');
})->name('home');

Route::get('/login', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('login');

// Halaman Kasir POS — dilindungi auth Filament
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/kasir', PosPage::class)->name('kasir.pos');
    Route::get('/kasir/riwayat', RiwayatPage::class)->name('kasir.riwayat');
    
    Route::get('/laporan-transaksi', function (\Illuminate\Http\Request $request) {
        $now = now();
        $start = $request->start;
        $end = $request->end;
        
        if ($request->has('periode')) {
            switch ($request->periode) {
                case 'hari_ini':
                    $start = $now->format('Y-m-d');
                    $end = $now->format('Y-m-d');
                    break;
                case 'kemarin':
                    $start = $now->copy()->subDay()->format('Y-m-d');
                    $end = $now->copy()->subDay()->format('Y-m-d');
                    break;
                case 'minggu_ini':
                    $start = $now->copy()->startOfWeek()->format('Y-m-d');
                    $end = $now->copy()->endOfWeek()->format('Y-m-d');
                    break;
                case 'bulan_ini':
                    $start = $now->copy()->startOfMonth()->format('Y-m-d');
                    $end = $now->copy()->endOfMonth()->format('Y-m-d');
                    break;
                case 'tahun_ini':
                    $start = $now->copy()->startOfYear()->format('Y-m-d');
                    $end = $now->copy()->endOfYear()->format('Y-m-d');
                    break;
                case 'semua':
                    $start = null;
                    $end = null;
                    break;
            }
        }
        
        $query = \App\Models\Pesanan::with('kasir', 'pembayarans');
        
        if ($start && $end) {
            $query->whereBetween('tanggal', [$start . ' 00:00:00', $end . ' 23:59:59']);
        }
        
        $pesanans = $query->get();
            
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.transaksi', compact('pesanans', 'start', 'end'));
        return $pdf->stream('laporan-transaksi-' . ($start ?? 'semua') . '-to-' . ($end ?? 'semua') . '.pdf');
    })->name('laporan.transaksi');
});
Route::get('/laporan/cetak', [App\Http\Controllers\LaporanController::class, 'cetak'])->name('laporan.cetak')->middleware(['web', 'auth']);

// Route Cetak Struk & Verifikasi
Route::get('/pesanan/cetak-struk/{id}', function ($id) {
    $pesanan = \App\Models\Pesanan::with(['detailPesanans.menu', 'kasir', 'meja', 'pembayarans', 'usaha'])->findOrFail($id);
    return view('reports.cetak-struk', compact('pesanan'));
})->name('pesanan.cetak-struk')->middleware(['web', 'auth']);

Route::get('/verifikasi-struk/{nomor_nota}', function ($nomor_nota) {
    $pesanan = \App\Models\Pesanan::with(['detailPesanans.menu', 'kasir', 'meja', 'pembayarans', 'usaha'])->where('nomor_nota', $nomor_nota)->firstOrFail();
    return view('reports.verifikasi-struk', compact('pesanan'));
})->name('verifikasi.struk');
