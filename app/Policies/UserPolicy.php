<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function update(User $authUser, User $user): bool
    {
        if ($user->hasRole('Super Admin')) {
            return $authUser->hasRole('Super Admin');
        }

        return $authUser->can('manage users');
    }

    public function delete(User $authUser, User $user): bool
    {
        if ($user->hasRole('Super Admin')) {
            return false;
        }

        return $authUser->can('manage users');
    }
}