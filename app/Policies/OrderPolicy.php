<?php

namespace Dipnet\Policies;

use Dipnet\User;
use Dipnet\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * User has permission to touch the Order model.
     *
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function touch(User $user, Order $order)
    {
        return $user->id == $order->user_id;
    }

    /**
     * User has permission to delete the Order.
     *
     * @param Order $order
     * @return bool
     */
    public function delete(User $user, Order $order)
    {
        return $user->id === $order->business->company->id;
    }
}
