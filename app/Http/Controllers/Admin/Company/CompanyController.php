<?php

namespace App\Http\Controllers\Admin\Company;

use App\Company;
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
        $this->middleware('admin');
    }

    /**
     * Display a list of all companies.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.companies.index');
    }

    /**
     * Store a new company.
     *
     * @param StoreCompanyRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = new Company;
        $company->name = $request->name;
        $company->slug = str_slug($request->name);
        $company->description = $request->description;
        $company->save();

        return response($company, 200);
    }

    /**
     * Update an existing company.
     *
     * @param UpdateCompanyRequest $request
     * @param Company $company
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->name = $request->name;
        $company->description = $request->description;
        $company->save();

        return response($company, 200);
    }

    /**
     * Delete an existing company.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return response(null, 204);
    }
}
