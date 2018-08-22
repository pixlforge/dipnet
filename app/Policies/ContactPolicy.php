<?php

namespace App\Policies;

use App\User;
use App\Contact;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Contact $contact
     * @return bool
     */
    public function view(User $user, Contact $contact)
    {
        if ($user->isPartOfACompany()) {
            return $contact->company_id == $user->company->id;
        } elseif ($user->isSolo()) {
            return $contact->user_id == $user->id;
        }
    }

    /**
     * @param User $user
     * @param Contact $contact
     * @return bool
     */
    public function update(User $user, Contact $contact)
    {
        if ($user->isPartOfACompany()) {
            return $contact->company_id == $user->company->id;
        } elseif ($user->isSolo()) {
            return $contact->user_id == $user->id;
        }
    }

    /**
     * @param User $user
     * @param Contact $contact
     * @return bool
     */
    public function delete(User $user, Contact $contact)
    {
        if ($user->isPartOfACompany()) {
            return $contact->company_id == $user->company->id;
        } elseif ($user->isSolo()) {
            return $contact->user_id == $user->id;
        }
    }
}
