<?php

namespace App\Http\Controllers\Admin\Company;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Invitation;
use App\Business;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index()
    {
        return view('admin.companies.index');
    }

    public function show(Company $company)
    {
        $invitations = Invitation::where('company_id', $company->id)->get();
        $businesses = Business::where('company_id', $company->id)->get();

        return view('companies.show', [
            'company' => $company,
            'invitations' => $invitations,
            'businesses' => $businesses
        ]);
    }

    public function store(StoreCompanyRequest $request)
    {
        $company = new Company;
        $company->name = $request->name;
        $company->description = $request->description;
        $company->status = $request->status;
        $company->save();

        return response($company, 200);
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->name = $request->name;
        $company->description = $request->description;
        $company->status = $request->status;
        $company->save();

        return response($company, 200);
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return response(null, 204);
    }
}
