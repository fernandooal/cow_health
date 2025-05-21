<?php

namespace App\Policies;

use App\Models\Farm;
use App\Models\User;

class FarmPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ViewAny Farm');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->hasPermissionTo('View Farm');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Farm');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('Update Farm');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Farm $farm): bool
    {
        if($farm->cows()->exists()){
            return false;
        }

        return $user->hasPermissionTo('Delete Collar');
    }
}
