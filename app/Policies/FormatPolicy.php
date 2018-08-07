<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class FormatPolicy
{
    use HandlesAuthorization;

    /**
     * @return mixed
     */
    public function view()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * @return mixed
     */
    public function delete()
    {
        return auth()->user()->isAdmin();
    }
}