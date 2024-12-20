<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    // To delete an user
    public function delete(User $user, User $deletinguser)
    {
        return ($user->id === $deletinguser->id) || ($user->is_admin);
    }

    // For admins & moderator
    public function moderator(User $user)
    {
        // \Log::info('Checking moderator policy', ['is_mod' => $user->is_mod, 'is_admin' => $user->is_admin]);
        return ($user->is_mod) || ($user->is_admin);
    }

    // For admins only
    public function admin(User $user)
    {
        return $user->is_admin;
    }

    // For everone except blocked
    public function unblocked(User $user)
    {
        return !($user->is_blocked);
    }

}
