<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @return mixed
     */
    public function view()
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can create users.
     *
     * @return mixed
     */
    public function create()
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param User $user
     * @return mixed
     */
    public function update(User $user)
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param User $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can restore the user.
     *
     * @return bool
     */
    public function restore()
    {
        return auth()->user()->role == 'administrateur';
    }
}
