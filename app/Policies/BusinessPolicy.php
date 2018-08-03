<?php

namespace App\Policies;

use App\User;
use App\Business;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Business $business)
    {
        if ($user->isNotSolo()) {
            return $user->company_id === $business->company_id;
        } elseif ($user->isSolo()) {
            return $user->id === $business->user_id;
        }
    }

    public function update(User $user, Business $business)
    {
        if ($user->isNotSolo()) {
            return $user->company_id === $business->company_id;
        } elseif ($user->isSolo()) {
            return $user->id === $business->user_id;
        }
    }

    public function delete()
    {
        return auth()->user()->isAdmin();
    }
}
