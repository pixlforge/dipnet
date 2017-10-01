<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\Contact;
use App\User;
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
        auth()->user()->associateModels($company->id);
    }
}
