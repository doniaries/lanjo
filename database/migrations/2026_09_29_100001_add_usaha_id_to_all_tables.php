<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan usaha_id ke tabel users (tenant isolation).
     * users bisa milik satu usaha (nullable untuk superadmin).
     */
    public function up(): void
    {
        // Gunakan hasColumn agar idempotent (tidak error jika sudah ada)
        if (! Schema::hasColumn('users', 'usaha_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('usaha_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('usahas')
                    ->nullOnDelete();
            });
        }

        // Tabel-tabel berikut semua perlu usaha_id untuk isolasi data tenant
        $tables = [
            'pengaturans',
            'kategori_menus',
            'menus',
            'mejas',
            'pesanans',
            'shifts',
        ];

        foreach ($tables as $tbl) {
            if (! Schema::hasColumn($tbl, 'usaha_id')) {
                Schema::table($tbl, function (Blueprint $table) use ($tbl) {
                    $table->foreignId('usaha_id')
                        ->nullable()
                        ->after('id')
                        ->constrained('usahas')
                        ->cascadeOnDelete();
                });
            }
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['usaha_id']);
            $table->dropColumn('usaha_id');
        });

        $tables = [
            'pengaturans',
            'kategori_menus',
            'menus',
            'mejas',
            'pesanans',
            'shifts',
        ];

        foreach ($tables as $tbl) {
            Schema::table($tbl, function (Blueprint $table) {
                $table->dropForeign(['usaha_id']);
                $table->dropColumn('usaha_id');
            });
        }
    }
};
