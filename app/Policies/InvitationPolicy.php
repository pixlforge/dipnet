<?php

namespace App\Policies;

use App\User;
use App\Invitation;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitationPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Invitation $invitation
     * @return bool
     */
    public function delete(User $user, Invitation $invitation)
    {
        return $user->company_id == $invitation->company_id;
    }
}