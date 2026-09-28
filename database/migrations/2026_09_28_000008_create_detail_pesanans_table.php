<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->cascadeOnDelete();
            $table->foreignId('menu_id')->constrained('menus');
            $table->foreignId('varian_menu_id')->nullable()->constrained('varian_menus')->nullOnDelete();
            $table->string('nama_menu_snapshot');
            $table->decimal('harga_satuan_snapshot', 12, 2);
            $table->integer('jumlah');
            $table->decimal('subtotal', 14, 2);
            $table->string('catatan_item')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};
