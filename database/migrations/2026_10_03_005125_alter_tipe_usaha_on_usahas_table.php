<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('usahas', function (Blueprint $table) {
            $table->dropColumn('tipe_usaha');
            $table->foreignId('tipe_usaha_id')->nullable()->constrained('tipe_usahas')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usahas', function (Blueprint $table) {
            $table->dropForeign(['tipe_usaha_id']);
            $table->dropColumn('tipe_usaha_id');
            $table->enum('tipe_usaha', ['restoran', 'katering', 'cafe'])->default('restoran');
        });
    }
};
