<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->cascadeOnDelete();
            $table->enum('metode', ['tunai', 'qris', 'transfer'])->default('tunai');
            $table->decimal('jumlah_bayar', 14, 2);
            $table->decimal('kembalian', 14, 2)->default(0);
            $table->dateTime('waktu_bayar');
            $table->foreignId('kasir_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
