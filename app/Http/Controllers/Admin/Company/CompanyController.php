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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.companies.index');
    }

    /**
     * @param StoreCompanyRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = new Company;
        $company->name = $request->name;
        $company->slug = str_slug($request->name);
        $company->description = $request->description;
        $company->status = $request->status;
        $company->save();

        return response($company, 200);
    }

    /**
     * @param UpdateCompanyRequest $request
     * @param Company $company
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->name = $request->name;
        $company->description = $request->description;
        $company->status = $request->status;
        $company->save();

        return response($company, 200);
    }

    /**
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
