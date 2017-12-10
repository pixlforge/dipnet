<?php

namespace Dipnet\Policies;

use Dipnet\User;
use Dipnet\Invitation;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitationPolicy
{
    use HandlesAuthorization;

    /**
     * Authorize model's deletion.
     *
     * @param User $user
     * @param Invitation $invitation
     * @return bool
     */
    public function delete(User $user, Invitation $invitation)
    {
        return $user->company_id == $invitation->company_id;
    }
}