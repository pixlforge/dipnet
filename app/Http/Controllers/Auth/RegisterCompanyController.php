<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Register\RegisterCompanyRequest;

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
        ]);

        auth()->user()->confirmCompany();
        auth()->user()->associateWithCompany($company->id);
        auth()->user()->associateContactWithCompany($company->id);
    }
}
