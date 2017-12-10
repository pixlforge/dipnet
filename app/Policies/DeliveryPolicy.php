<?php

namespace Dipnet\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryPolicy
{
    use HandlesAuthorization;

    /**
     * User has permission to view the Delivery.
     *
     * @return bool
     */
    public function view()
    {
        return true;
    }

    /**
     * User has permission to delete the Delivery.
     *
     * @return bool
     */
    public function delete()
    {
        return true;
    }
}
