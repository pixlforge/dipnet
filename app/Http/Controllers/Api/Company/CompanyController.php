<?php

namespace App\Http\Controllers\Api\Company;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompaniesCollection;

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
