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
        $start = $request->start;
        $end = $request->end;
        
        $pesanans = \App\Models\Pesanan::with('kasir', 'pembayarans')
            ->whereBetween('tanggal', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->get();
            
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.transaksi', compact('pesanans', 'start', 'end'));
        return $pdf->stream('laporan-transaksi-' . $start . '-to-' . $end . '.pdf');
    })->name('laporan.transaksi');
});
Route::get('/laporan/cetak', [App\Http\Controllers\LaporanController::class, 'cetak'])->name('laporan.cetak')->middleware(['web', 'auth']);
