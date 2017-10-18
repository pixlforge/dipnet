<?php

namespace App\Policies;

use App\User;
use App\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the articles.
     *
     * @return mixed
     */
    public function view()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Determine whether the user can create articles.
     *
     * @return mixed
     */
    public function create()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Determine whether the user can update the articles.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function update(User $user, Article $article)
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Determine whether the user can delete the articles.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function delete(User $user, Article $article)
    {
        return auth()->user()->isAdmin();
    }
}
