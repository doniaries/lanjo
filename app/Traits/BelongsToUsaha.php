<?php

namespace App\Traits;

use App\Scopes\UsahaScope;

/**
 * Trait ini ditambahkan ke setiap Model yang harus diisolasi per tenant.
 * Cukup gunakan: use BelongsToUsaha;
 */
trait BelongsToUsaha
{
    protected static function bootBelongsToUsaha(): void
    {
        // Daftarkan global scope saat model di-boot
        static::addGlobalScope(new UsahaScope());

        // Auto-set usaha_id saat membuat record baru
        static::creating(function ($model) {
            if (auth()->check() && empty($model->usaha_id)) {
                /** @var \App\Models\User|null $user */
                $user = auth()->user();

                if ($user->usaha_id) {
                    $model->usaha_id = $user->usaha_id;
                }
            }
        });
    }

    public function usaha(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Usaha::class);
    }
}
