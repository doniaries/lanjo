<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements FilamentUser, HasAvatar, HasTenants
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

    public function getTenants(Panel $panel): array|Collection
    {
        if ($this->isSuperadmin()) {
            return Usaha::all();
        }
        return $this->usaha ? [$this->usaha] : [];
    }

    public function canAccessTenant(Model $tenant): bool
    {
        if ($this->isSuperadmin()) {
            return true;
        }
        return $this->usaha_id === $tenant->id;
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
        if (! $this->avatar_url) {
            return null;
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        return $disk->url($this->avatar_url);
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
