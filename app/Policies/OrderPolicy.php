<?php

namespace App\Policies;

use App\User;
use App\Order;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

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
    public function delete(Order $order)
    {
        return auth()->id() == $order->user_id;
    }
}
