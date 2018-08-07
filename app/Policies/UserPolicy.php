<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @return bool
     */
    public function view()
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->role == 'administrateur';
    }

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->isAdmin();
    }
}
