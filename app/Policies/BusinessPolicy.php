<?php

namespace Dipnet\Policies;

use Dipnet\Business;
use Dipnet\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessPolicy
{
    use HandlesAuthorization;

    /**
     * User has permission to view every Business.
     *
     * @param User $user
     * @param Business $business
     * @return mixed
     */
    public function view(User $user, Business $business)
    {
        if ($user->isNotSolo()) {
            return $user->company_id === $business->company_id;
        }
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
