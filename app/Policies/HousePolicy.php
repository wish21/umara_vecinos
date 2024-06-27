<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\House;
use App\Models\User;

class HousePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any House');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, House $house): bool
    {
        return $user->checkPermissionTo('view House');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create House');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, House $house): bool
    {
        return $user->checkPermissionTo('update House');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, House $house): bool
    {
        return $user->checkPermissionTo('delete House');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, House $house): bool
    {
        return $user->checkPermissionTo('restore House');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, House $house): bool
    {
        return $user->checkPermissionTo('force-delete House');
    }
}
