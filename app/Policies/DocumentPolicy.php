<?php

namespace Dipnet\Policies;

use Dipnet\User;
use Dipnet\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the document.
     *
     * @return mixed
     */
    public function view()
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can create documents.
     *
     * @return mixed
     */
    public function create()
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can update the document.
     *
     * @param  \Dipnet\User  $user
     * @param  \Dipnet\Document  $document
     * @return mixed
     */
    public function update(User $user, Document $document)
    {
        return auth()->user()->role == 'administrateur';
    }

    /**
     * Determine whether the user can delete the document.
     *
     * @param  \Dipnet\User  $user
     * @param  \Dipnet\Document  $document
     * @return mixed
     */
    public function delete(User $user, Document $document)
    {
        return auth()->user()->role == 'administrateur';
    }
}
