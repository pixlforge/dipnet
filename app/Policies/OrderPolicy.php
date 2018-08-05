<?php

namespace App\Policies;

use App\Order;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->isAdmin();
    }

    public function touch(User $user, Order $order)
    {
        if ($user->isPartOfACompany()) {
            return $order->company->id == $user->company->id;
        } elseif ($user->isSolo()) {
            return $order->user_id == $user->id;
        }
    }

    public function delete(User $user, Order $order)
    {
        return $user->company_id === $order->business->company->id;
    }
}
