<?php

namespace App\Policies;

use App\User;
use App\Delivery;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Delivery $delivery
     * @return bool
     */
    public function touch(User $user, Delivery $delivery)
    {
        if ($user->isPartOfACompany()) {
            return $delivery->order->company_id == $user->company->id;
        } elseif ($user->isSolo()) {
            return $delivery->order->user_id == $user->id;
        }
    }
}
