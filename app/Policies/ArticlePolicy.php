<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view articles.
     *
     * @return mixed
     */
    public function view()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Check wether the user has permission to delete articles.
     *
     * @return mixed
     */
    public function delete()
    {
        return auth()->user()->isAdmin();
    }
}
