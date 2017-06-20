<?php

namespace App\Policies;

use App\User;
use App\Business;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the business.
     *
     * @return mixed
     */
    public function view()
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can create businesses.
     *
     * @return mixed
     */
    public function create()
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can update the business.
     *
     * @param  \App\User  $user
     * @param  \App\Business  $business
     * @return mixed
     */
    public function update(User $user, Business $business)
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can delete the business.
     *
     * @param  \App\User  $user
     * @param  \App\Business  $business
     * @return mixed
     */
    public function delete(User $user, Business $business)
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can restore the business.
     *
     * @return bool
     */
    public function restore()
    {
        return auth()->user()->role == 'administrateur';
    }
}
