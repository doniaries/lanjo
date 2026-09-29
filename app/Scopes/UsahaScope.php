<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Global scope yang secara otomatis memfilter query berdasarkan usaha_id
 * dari user yang sedang login. Superadmin tidak difilter.
 */
class UsahaScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (! \Illuminate\Support\Facades\Auth::check()) {
            return;
        }

        // Cek jika kita di dalam konteks Filament dan tenant sudah dipilih
        if (class_exists(\Filament\Facades\Filament::class) && \Filament\Facades\Filament::hasTenancy() && $tenant = \Filament\Facades\Filament::getTenant()) {
            $builder->where($model->getTable() . '.usaha_id', $tenant->id);
            return;
        }

        /** @var \App\Models\User|null $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        // Superadmin melihat semua (hanya jika di luar konteks Tenant)
        if ($user->tipe === 'superadmin') {
            return;
        }

        if ($user->usaha_id) {
            $builder->where($model->getTable() . '.usaha_id', $user->usaha_id);
        }
    }
}
