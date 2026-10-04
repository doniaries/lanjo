<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Filament\Models\Contracts\HasName;
use Illuminate\Support\Str;

class Usaha extends Model implements HasName
{
    protected $guarded = [];

    protected $casts = [
        'is_active'    => 'boolean',
        'pajak_aktif'  => 'boolean',
        'pajak_default' => 'decimal:2',
    ];

    public function getFilamentName(): string
    {
        return $this->nama_usaha ?? 'Tanpa Nama';
    }

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

    public function isFree(): bool
    {
        return $this->paket === 'free';
    }

    public function isPremium(): bool
    {
        return $this->paket === 'premium';
    }

    public function tipeUsaha()
    {
        return $this->belongsTo(TipeUsaha::class, 'tipe_usaha_id');
    }
}
