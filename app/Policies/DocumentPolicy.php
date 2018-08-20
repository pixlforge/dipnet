<?php

namespace App\Policies;

use App\User;
use App\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Document $document
     * @return bool
     */
    public function touch(User $user, Document $document)
    {
        if ($user->isAdmin()) {
            return true;
        } elseif ($user->isPartOfACompany()) {
            return $document->delivery->order->company_id == $user->company->id;
        } elseif ($user->isSolo()) {
            return $document->delivery->order->user_id == $user->id;
        }
    }
}
