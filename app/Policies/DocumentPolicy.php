<?php

namespace App\Policies;

use App\User;
use App\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function touch(User $user, Document $document)
    {
        if ($user->isPartOfACompany()) {
            return $document->delivery->order->company_id == $user->company->id;
        } elseif ($user->isSolo()) {
            return $document->delivery->order->user_id == $user->id;
        }
    }
}
