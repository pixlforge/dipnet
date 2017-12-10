<?php

namespace Dipnet\Policies;

use Dipnet\User;
use Dipnet\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    public function touch()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Determine whether the user can view the company.
     *
     * @return mixed
     */
    public function view()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Determine whether the user can create companies.
     *
     * @return mixed
     */
    public function create()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Determine whether the user can update the company.
     *
     * @param  \Dipnet\User  $user
     * @param  \Dipnet\Company  $company
     * @return mixed
     */
    public function update(User $user, Company $company)
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Determine whether the user can delete the company.
     *
     * @param  \Dipnet\User  $user
     * @param  \Dipnet\Company  $company
     * @return mixed
     */
    public function delete(User $user, Company $company)
    {
        return auth()->user()->isAdmin();
    }
}
