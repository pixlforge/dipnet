<?php

namespace Dipnet\Http\Controllers\Company;

use Dipnet\Company;
use Dipnet\Invitation;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Requests\Company\StoreCompanyRequest;
use Dipnet\Http\Requests\Company\UpdateCompanyRequest;

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
     */
    public function index()
    {
        $this->authorize('touch', Company::class);

        $companies = Company::orderBy('name')
            ->get()
            ->toJson();

        return view('companies.index', [
            'companies' => $companies
        ]);
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

        return view('companies.show', [
            'company' => $company,
            'invitations' => $invitations
        ]);
    }

    /**
     * Update the Company.
     *
     * @param UpdateCompanyRequest $request
     * @param Company $company
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->update([
            'name' => $request->name,
            'status' => $request->status,
            'description' => $request->description
        ]);

        return response($company, 200);
    }

    /**
     * Delete the Company.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);

        $company->delete();

        return response(null, 204);
    }
}
