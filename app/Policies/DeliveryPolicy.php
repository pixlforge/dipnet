<?php

namespace App\Policies;

use App\User;
use App\Delivery;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryPolicy
{
    use HandlesAuthorization;

    public function touch(User $user, Delivery $delivery)
    {
        if ($user->isPartOfACompany()) {
            return $delivery->order->company->id == $user->company->id;
        } elseif ($user->isSolo()) {
            return $delivery->order->user->id == $user->id;
        }
    }
}
