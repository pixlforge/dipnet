<?php

namespace App\Http\Controllers\Search;

use App\Business;
use App\Company;
use App\Delivery;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search()
    {
        $orders = Order::where('reference', 'like', request('query') . '%')
            ->limit(5)
            ->get();

        $companies = Company::where('name', 'like', request('query') . '%')
            ->limit(5)
            ->get();

        $businesses = Business::where('name', 'like', request('query') . '%')
            ->limit(5)
            ->get();

        $deliveries = Delivery::where('reference', 'like', request('query') . '%')
            ->limit(5)
            ->get();

        if (request()->wantsJson()) {
            return response([
                $orders->toArray(),
                $companies->toArray(),
                $businesses->toArray(),
                $deliveries->toArray(),
            ]);
        }
    }

    public function testing()
    {
        $companies = Company::where('name', 'like', '%Sau%')
            ->limit(5)
            ->get();

        return $companies;
    }
}
