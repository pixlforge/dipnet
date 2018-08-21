<?php

namespace App\Http\Controllers\Search;

use App\Order;
use App\Company;
use App\Contact;
use App\Delivery;
use App\Business;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * SearchController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Query the database.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function search()
    {
        $orders = [];
        $companies = [];
        $businesses = [];
        $deliveries = [];
        $contacts = [];

        if (auth()->user()->isAdmin()) {
            $orders = Order::select(['id', 'reference'])
                ->where('reference', 'like', '%' . request('query') . '%')
                ->latest()
                ->limit(5)
                ->get()
                ->toArray();

            $deliveries = Delivery::with('order')
                ->select(['id', 'reference', 'order_id'])
                ->where('reference', 'like', '%' . request('query') . '%')
                ->latest()
                ->limit(5)
                ->get()
                ->toArray();

            // $companies = Company::select(['id', 'name'])
            //     ->where('name', 'like', '%' . request('query') . '%')
            //     ->latest()
            //     ->limit(5)
            //     ->get()
            //     ->toArray();

            // $businesses = Business::select(['id', 'name'])
            //     ->where('name', 'like', '%' . request('query') . '%')
            //     ->latest()
            //     ->limit(5)
            //     ->get()
            //     ->toArray();

            // $contacts = Contact::select(['id', 'name'])
            //     ->where('name', 'like', '%' . request('query') . '%')
            //     ->latest()
            //     ->limit(5)
            //     ->get()
            //     ->toArray();
        }

        if (auth()->user()->isNotAdmin()) {

            // Search for the orders placed by the user.
            $orders = Order::select(['id', 'reference'])
                ->where([
                    ['user_id', auth()->id()],
                    ['reference', 'like', '%' . request('query') . '%']
                ])
                ->latest()
                ->limit(5)
                ->get()
                ->toArray();

            // Search for the deliveries related to the user's company.
            $deliveries = auth()->user()->deliveries()
                ->with('order')
                ->where('reference', 'like', '%' . request('query') . '%')
                ->latest()
                ->limit(5)
                ->get()
                ->toArray();

            // Search for the user's own company.
            // $companies = Company::select(['id', 'name'])
            //     ->where([
            //         ['id', auth()->user()->company_id],
            //         ['name', 'like', '%' . request('query') . '%']
            //     ])
            //     ->get()
            //     ->toArray();

            // Show the businesses related the user's company
            // $businesses = Business::select(['id', 'name'])
            //     ->where([
            //         ['company_id', auth()->user()->company_id],
            //         ['name', 'like', '%' . request('query') . '%']
            //     ])
            //     ->latest()
            //     ->limit(5)
            //     ->get()
            //     ->toArray();

            // Search for the contacts related to the user.
            // $contacts = Contact::select(['id', 'name'])
            //     ->where([
            //         ['user_id', auth()->id()],
            //         ['name', 'like', '%' . request('query') . '%']
            //     ])
            //     ->latest()
            //     ->limit(5)
            //     ->get()
            //     ->toArray();
        }

        return response([
            $orders,
            $companies,
            $businesses,
            $deliveries,
            $contacts,
        ]);
    }
}
