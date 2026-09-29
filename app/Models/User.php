<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    protected $connection = 'mysql';

    protected $fillable = [
        'usaha_id',
        'name',
        'email',
        'password',
        'is_active',
        'kontak',
        'avatar_url',
        'email_verified_at',
        'tipe',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // ─── Multi-tenant ────────────────────────────────────────────────────

    public function usaha(): BelongsTo
    {
        return $this->belongsTo(Usaha::class);
    }

    public function isSuperadmin(): bool
    {
        return $this->tipe === 'superadmin';
    }

    public function isPemilik(): bool
    {
        return $this->tipe === 'pemilik';
    }

    // ─── Filament ────────────────────────────────────────────────────────

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url
            ? Storage::disk('public')->url($this->avatar_url)
            : null;
    }

    protected static function booted(): void
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('badge_users_count');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('badge_users_count');
        });
    }
}

