<?php

use App\Livewire\Kasir\PosPage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
})->name('home');

// Halaman Kasir POS — dilindungi auth Filament
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/kasir', PosPage::class)->name('kasir.pos');
});
