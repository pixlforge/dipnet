<?php

namespace App\Http\Controllers\Companies;

use App\Company;
use App\Invitation;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;

class CompaniesController extends Controller
{
    /**
     * CompaniesController constructor.
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
     * Persist a new Company model.
     *
     * @param CompanyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $this->authorize('create', Company::class);

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
     * Update the specified resource in storage.
     *
     * @param CompanyRequest $request
     * @param Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $this->authorize('update', $company);

        $company->update([
            'name' => $request->name,
            'status' => $request->status,
            'description' => $request->description
        ]);

        return response($company, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);

        $company->delete();

        return response(null, 204);
    }
}
