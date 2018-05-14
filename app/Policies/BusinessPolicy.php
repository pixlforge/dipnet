<?php

namespace App\Policies;

use App\Business;
use App\User;
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
        } else if ($user->isSolo()) {
            return $user->id === $business->user_id;
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
