<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TipeUsaha;
use Illuminate\Auth\Access\HandlesAuthorization;

class TipeUsahaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TipeUsaha');
    }

    public function view(AuthUser $authUser, TipeUsaha $tipeUsaha): bool
    {
        return $authUser->can('View:TipeUsaha');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TipeUsaha');
    }

    public function update(AuthUser $authUser, TipeUsaha $tipeUsaha): bool
    {
        return $authUser->can('Update:TipeUsaha');
    }

    public function delete(AuthUser $authUser, TipeUsaha $tipeUsaha): bool
    {
        return $authUser->can('Delete:TipeUsaha');
    }

    public function restore(AuthUser $authUser, TipeUsaha $tipeUsaha): bool
    {
        return $authUser->can('Restore:TipeUsaha');
    }

    public function forceDelete(AuthUser $authUser, TipeUsaha $tipeUsaha): bool
    {
        return $authUser->can('ForceDelete:TipeUsaha');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TipeUsaha');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TipeUsaha');
    }

    public function replicate(AuthUser $authUser, TipeUsaha $tipeUsaha): bool
    {
        return $authUser->can('Replicate:TipeUsaha');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TipeUsaha');
    }

}