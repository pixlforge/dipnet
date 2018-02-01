<?php

namespace Dipnet\Http\Controllers\Api\Company;

use Dipnet\Company;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Resources\CompaniesCollection;

class CompanyController extends Controller
{
    /**
     * CompanyController constructor.
     */
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    /**
     * @return CompaniesCollection
     */
    public function index()
    {
        return new CompaniesCollection(Company::orderBy('name')->paginate(25));
    }
}
