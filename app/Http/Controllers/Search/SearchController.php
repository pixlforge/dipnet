<?php

namespace App\Http\Controllers\Search;

use App\Order;
use App\Company;
use App\Business;
use App\Delivery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Search in models
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function search()
    {
        // TODO: ordonner par created_at
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
}
