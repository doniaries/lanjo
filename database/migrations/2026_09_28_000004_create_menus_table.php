<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_menu_id')->constrained('kategori_menus')->cascadeOnDelete();
            $table->string('nama');
            $table->decimal('harga_jual', 12, 2);
            $table->decimal('harga_modal', 12, 2)->default(0);
            $table->string('gambar')->nullable();
            $table->integer('stok')->default(0);
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
