<?php

use App\Livewire\Kasir\PosPage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
})->name('home');

Route::get('/login', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('login');

// Halaman Kasir POS — dilindungi auth Filament
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/kasir', PosPage::class)->name('kasir.pos');
});
