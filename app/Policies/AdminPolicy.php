<?php

namespace Dipnet\Policies;

use Dipnet\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function view()
    {
        return auth()->user()->role == 'administrateur';
    }
}
