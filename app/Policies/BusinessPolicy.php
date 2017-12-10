<?php

namespace Dipnet\Policies;

use Dipnet\Business;
use Dipnet\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessPolicy
{
    use HandlesAuthorization;

    /**
     * User has permission to view every Business.
     *
     * @return mixed
     */
    public function view()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * User has permission to delete the Business.
     *
     * @return mixed
     */
    public function delete()
    {
        return auth()->user()->isAdmin();
    }
}
