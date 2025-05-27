<?php

namespace App\Policies;

use App\Models\Collar;
use App\Models\User;

class CollarPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ViewAny Collar');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->hasPermissionTo('View Collar');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Collar');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('Update Collar');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Collar $collar): bool
    {
        if($collar->cow()->exists()){
            return false;
        }

        return $user->hasPermissionTo('Delete Collar');
    }
}
