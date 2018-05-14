<?php

namespace App\Http\Controllers\Company;

use App\Business;
use App\Company;
use App\Invitation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;

class CompanyController extends Controller
{
    /**
     * CompanyController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'user.email.confirmed']);
    }

    /**
     * Display a listing of the Companies.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('touch', Company::class);

        return view('companies.index');
    }

    /**
     * Store a new Company.
     *
     * @param StoreCompanyRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create([
            'name' => $request->name,
            'status' => $request->status,
            'description' => $request->description,
            'created_by_username' => auth()->user()->username
        ]);

        return response($company, 200);
    }

    /**
     * Show the specified Company.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * Update the Company.
     *
     * @param UpdateCompanyRequest $request
     * @param Company $company
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $this->authorize('update', $company);

        $company->name = $request->name;
        $company->status = $request->status;
        $company->description = $request->description;
        $company->business_id = $request->business_id;
        $company->save();

        return response($company, 200);
    }

    /**
     * Delete the Company.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);

        $company->delete();

        return response(null, 204);
    }
}
