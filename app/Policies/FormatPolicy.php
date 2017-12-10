<?php

namespace Dipnet\Policies;

use Dipnet\User;
use Dipnet\Format;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormatPolicy
{
    use HandlesAuthorization;

    /**
     * User has permission to view the Format.
     *
     * @return mixed
     */
    public function view()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * User has permission to delete the Format.
     *
     * @return mixed
     */
    public function delete()
    {
        return auth()->user()->isAdmin();
    }
}