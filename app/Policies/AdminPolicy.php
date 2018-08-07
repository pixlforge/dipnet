<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * @return bool
     */
    public function view()
    {
        return auth()->user()->role == 'administrateur';
    }
}
