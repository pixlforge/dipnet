<?php

namespace App\Policies;

use App\Delivery;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryPolicy
{
    use HandlesAuthorization;

    /**
     * User has permission to view the delivery.
     *
     * @return bool
     */
    public function view()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * User has permission to update a delivery.
     *
     * @param User $user
     * @param Delivery $delivery
     * @return bool
     */
    public function update(User $user, Delivery $delivery)
    {
        if ($user->isSolo()) {
            return $delivery->orderBelongsToUser();
        } else {
            return $user->isAdmin() or $delivery->belongsToUsersCompany();
        }
    }

    /**
     * User has permission to delete the delivery.
     *
     * @param User $user
     * @param Delivery $delivery
     * @return bool
     */
    public function delete(User $user, Delivery $delivery)
    {
        if ($user->isSolo()) {
            return $delivery->orderBelongsToUser();
        } else {
            return $user->isAdmin() or $delivery->belongsToUsersCompany();
        }
    }
}
