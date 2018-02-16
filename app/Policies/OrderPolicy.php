<?php

namespace Dipnet\Policies;

use Dipnet\Order;
use Dipnet\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * User has permission to view the page.
     *
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        return $user->isAdmin();
    }

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
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function delete(User $user, Order $order)
    {
        return $user->company_id === $order->business->company->id;
    }
}
