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
        if (! auth()->check()) {
            return;
        }

        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        // Superadmin bisa lihat semua data
        if ($user->tipe === 'superadmin') {
            return;
        }

        if ($user->usaha_id) {
            $builder->where($model->getTable() . '.usaha_id', $user->usaha_id);
        }
    }
}
