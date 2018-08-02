<?php

namespace App\Http\Controllers\Company;

use App\Company;
use App\Business;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\StoreCompanyDefaultBusinessRequest;
use App\Http\Requests\Business\UpdateCompanyDefaultBusinessRequest;

class CompanyDefaultBusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StoreCompanyDefaultBusinessRequest $request, Company $company)
    {
        $this->authorize('touch', $company);

        $business = new Business;
        $business->name = $request->name;
        $business->description = $request->description;
        $business->contact_id = $request->contact_id;
        $business->save();

        $company->defaultBusiness()->associate($business);
        $company->save();

        return response(null, 200);
    }

    public function edit()
    {
        if (auth()->user()->isPartOfACompany()) {
            $company = auth()->user()->company()->with('contacts')->first();
            $businesses = Business::where('company_id', auth()->user()->company->id)->get();
        }
        
        return view('companies.default.business.edit', compact('company', 'businesses'));
    }

    public function update(UpdateCompanyDefaultBusinessRequest $request, Company $company)
    {
        $this->authorize('touch', $company);

        $company = Company::where('id', $company->id)->first();
        $business = Business::where('id', $request->business_id)->first();

        abort_if($company->id !== $business->company_id, 403, "Vous n'êtes pas autorisé à faire cela.");

        $company->defaultBusiness()->associate($business);
        $company->save();

        return response(null, 200);
    }
}
