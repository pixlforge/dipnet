<?php

namespace Dipnet\Policies;

use Dipnet\User;
use Dipnet\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the document.
     *
     * @param  \Dipnet\User  $user
     * @param  \Dipnet\Document  $document
     * @return mixed
     */
    public function delete(User $user, Document $document)
    {
        return $user->company_id == $document->delivery->order->business->company->id;
    }
}
