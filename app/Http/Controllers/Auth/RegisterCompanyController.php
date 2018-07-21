<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\Register\RegisterCompanyRequest;

class RegisterCompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(RegisterCompanyRequest $request)
    {
        $company = new Company;
        $company->name = $request->name;
        $company->description = $request->description;
        $company->save();

        auth()->user()->confirmCompany();
        auth()->user()->associateWithCompany($company->id);
        auth()->user()->associateContactWithCompany($company->id);
    }
}
