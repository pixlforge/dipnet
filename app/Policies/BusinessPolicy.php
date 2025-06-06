<?php

namespace App\Policies;

use App\User;
use App\Business;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Business $business
     * @return bool
     */
    public function view(User $user, Business $business)
    {
        if ($user->isAdmin()) {
            return true;
        } elseif ($user->isPartOfACompany()) {
            return $user->company_id === $business->company_id;
        } elseif ($user->isSolo()) {
            return $user->id === $business->user_id;
        }
    }

    /**
     * @param User $user
     * @param Business $business
     * @return bool
     */
    public function update(User $user, Business $business)
    {
        if ($user->isPartOfACompany()) {
            return $user->company_id === $business->company_id;
        } elseif ($user->isSolo()) {
            return $user->id === $business->user_id;
        }
    }

    /**
     * Checks whether the user is authorized to make a delete request.
     *
     * @param User $user
     * @param Business $business
     * @return bool
     */
    public function delete(User $user, Business $business)
    {
        if ($user->isPartOfACompany()) {
            return $user->company_id === $business->company_id;
        } elseif ($user->isSolo()) {
            return $user->id === $business->user_id;
        }
    }

    /**
     * @param User $user
     * @param Business $business
     * @return bool
     */
    public function comment(User $user, Business $business)
    {
        if ($user->isPartOfACompany()) {
            return $user->company_id === $business->company_id;
        } elseif ($user->isSolo()) {
            return $user->id === $business->user_id;
        }
    }
}
