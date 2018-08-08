<?php

namespace App\Http\Controllers\Company;

use App\Company;
use App\Business;
use App\Invitation;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    /**
     * Show a company's details.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Company $company)
    {
        $invitations = Invitation::where('company_id', $company->id)->get();
        $businesses = Business::where('company_id', $company->id)->get();

        return view('companies.show', compact('company', 'invitations', 'businesses'));
    }
}
