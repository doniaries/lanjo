<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usahas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_usaha');
            $table->string('slug')->unique();
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->enum('tipe_usaha', ['restoran', 'katering', 'cafe'])->default('restoran');
            $table->decimal('pajak_default', 5, 2)->default(0);
            $table->boolean('pajak_aktif')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usahas');
    }
};
