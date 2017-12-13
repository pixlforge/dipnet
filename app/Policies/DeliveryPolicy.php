<?php

namespace Dipnet\Policies;

use Dipnet\Delivery;
use Dipnet\User;
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
        return $user->isAdmin() or $delivery->belongsToUsersCompany();
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
        return $user->isAdmin() or $delivery->belongsToUsersCompany();
    }
}
