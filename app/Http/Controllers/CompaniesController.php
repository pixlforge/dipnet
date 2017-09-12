<?php

namespace App\Http\Controllers;

use App\Company;
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
        $this->authorize('view', Company::class);

        $companies = Company::orderBy('name')
            ->get();

        return view('companies.index', compact('companies'));
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
            'name' => request('name'),
            'status' => request('status'),
            'description' => request('description'),
            'created_by_username' => auth()->user()->username
        ]);

        if (request()->expectsJson()) {
            return $company->id;
        }

        return redirect()->route('companies');
    }

    /**
     * Show the specified Company.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
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
            'name' => request('name'),
            'status' => request('status'),
            'description' => request('description')
        ]);

        return redirect()->route('companies');
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

        return redirect()->route('companies');
    }

    /**
     * Restores a previously soft deleted model.
     *
     * @param $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($company)
    {
        $this->authorize('restore', Company::class);

        Company::onlyTrashed()->where('id', $company)->restore();

        return redirect()->route('companies');
    }
}
