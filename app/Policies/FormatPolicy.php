<?php

namespace App\Policies;

use App\User;
use App\Format;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormatPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the format.
     *
     * @return mixed
     */
    public function view()
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can create formats.
     *
     * @return mixed
     */
    public function create()
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can update the format.
     *
     * @param  \App\Format  $format
     * @return mixed
     */
    public function update(User $user, Format $format)
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can delete the format.
     *
     * @param  \App\Format  $format
     * @return mixed
     */
    public function delete(User $user, Format $format)
    {
        return auth()->user()->role == 'administrateur';
    }


    /**
     * Determine whether the user can restore the format.
     *
     * @return bool
     */
    public function restore()
    {
        return auth()->user()->role == 'administrateur';
    }
}
