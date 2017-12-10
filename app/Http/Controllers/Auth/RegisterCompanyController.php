<?php

namespace Dipnet\Http\Controllers\Auth;

use Dipnet\Company;
use Illuminate\Http\Request;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Requests\Register\RegisterCompanyRequest;

class RegisterCompanyController extends Controller
{
    /**
     * RegisterCompanyController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new company associated with a newly created user.
     *
     * @param RegisterCompanyRequest|Request $request
     */
    public function store(RegisterCompanyRequest $request)
    {
        $company = Company::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by_username' => auth()->user()->username
        ]);

        auth()->user()->confirmCompany();
        auth()->user()->associateWithCompany($company->id);
        auth()->user()->associateContactWithCompany($company->id);
    }
}
