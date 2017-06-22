<?php

namespace App\Policies;

use App\User;
use App\Profile;
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
