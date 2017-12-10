<?php

namespace Dipnet\Policies;

use Dipnet\User;
use Dipnet\Profile;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UpdateProfilePolicy
{
    use HandlesAuthorization;

    /**
     * @return bool
     */
    public function view()
    {
        return Auth()->check();
    }
}
