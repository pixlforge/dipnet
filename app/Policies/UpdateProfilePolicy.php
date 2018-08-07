<?php

namespace App\Policies;

use App\Profile;
use Illuminate\Auth\Access\HandlesAuthorization;

class UpdateProfilePolicy
{
    use HandlesAuthorization;

    /**
     * @return bool
     */
    public function view()
    {
        return auth()->check();
    }
}
