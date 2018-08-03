<?php

namespace App\Policies;

use App\User;
use App\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    public function touch(User $user, Company $company)
    {
        return $user->isAdmin() || $user->company_id == $company->id;
    }
}
