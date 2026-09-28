<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_nota')->unique();
            $table->dateTime('tanggal');
            $table->foreignId('meja_id')->nullable()->constrained('mejas')->nullOnDelete();
            $table->enum('tipe_pesanan', ['dine_in', 'take_away'])->default('dine_in');
            $table->foreignId('kasir_id')->constrained('users');
            $table->enum('status', ['baru', 'selesai', 'batal'])->default('baru');
            $table->decimal('subtotal', 14, 2)->default(0);
            $table->decimal('diskon_nilai', 14, 2)->default(0);
            $table->decimal('pajak_nilai', 14, 2)->default(0);
            $table->decimal('total_akhir', 14, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
