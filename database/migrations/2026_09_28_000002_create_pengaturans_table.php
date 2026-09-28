<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko');
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->enum('tipe_toko', ['restoran', 'katering'])->default('restoran');
            $table->decimal('pajak_default', 5, 2)->default(0);
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};
