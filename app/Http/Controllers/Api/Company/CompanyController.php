<?php

namespace App\Http\Controllers\Api\Company;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompaniesCollection;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index($sort = null)
    {
        if ($sort) {
            if ($sort === 'created_at') {
                return new CompaniesCollection(
                    Company::orderBy($sort, 'desc')->orderBy('name')->paginate(25)
                );
            } else {
                return new CompaniesCollection(
                    Company::orderBy($sort)->orderBy('name')->paginate(25)
                );
            }
        } else {
            return new CompaniesCollection(
                Company::orderBy('name')->paginate(25)
            );
        }
    }
}
