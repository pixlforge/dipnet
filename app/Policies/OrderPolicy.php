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
     * Determine whether the user can view the order.
     *
     * @return mixed
     */
    public function view()
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can create orders.
     *
     * @return mixed
     */
    public function create()
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function update(User $user, Order $order)
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can delete the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function delete(User $user, Order $order)
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can restore the order.
     *
     * @return bool
     */
    public function restore()
    {
        return auth()->user()->role == 'administrateur';
    }
}
