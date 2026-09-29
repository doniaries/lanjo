<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Usaha extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active'    => 'boolean',
        'pajak_aktif'  => 'boolean',
        'pajak_default' => 'decimal:2',
    ];

    // ─── Boot: auto-generate slug ─────────────────────────────────────────
    protected static function booted(): void
    {
        static::creating(function (Usaha $usaha) {
            if (empty($usaha->slug)) {
                $usaha->slug = Str::slug($usaha->nama_usaha);
            }
        });
    }

    // ─── Relasi ───────────────────────────────────────────────────────────

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function pengaturans(): HasMany
    {
        return $this->hasMany(Pengaturan::class);
    }

    public function kategoriMenus(): HasMany
    {
        return $this->hasMany(KategoriMenu::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function mejas(): HasMany
    {
        return $this->hasMany(Meja::class);
    }

    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }

    public function shifts(): HasMany
    {
        return $this->hasMany(Shift::class);
    }
}
