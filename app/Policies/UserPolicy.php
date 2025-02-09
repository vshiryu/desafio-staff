<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function accessRegions(User $user): bool
    {
        return $user->access_level === 3;
    }
    
    public function accessStates(User $user): bool
    {
        return $user->access_level === 2;
    }
    
    public function accessCities(User $user): bool
    {
        return $user->access_level === 1;
    }
}
