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

            $companies = Company::select(['id', 'name', 'slug'])
                ->where('name', 'like', '%' . request('query') . '%')
                ->latest()
                ->limit(5)
                ->get()
                ->toArray();

            $businesses = Business::select(['id', 'name', 'reference'])
                ->where('name', 'like', '%' . request('query') . '%')
                ->latest()
                ->limit(5)
                ->get()
                ->toArray();

            $contacts = Contact::select(['id', 'name'])
                ->where('name', 'like', '%' . request('query') . '%')
                ->latest()
                ->limit(5)
                ->get()
                ->toArray();
        }

        if (auth()->user()->isNotAdmin()) {
            if (auth()->user()->isPartOfACompany()) {
                $orders = Order::select(['id', 'reference'])
                    ->where([
                        ['company_id', auth()->user()->company->id],
                        ['reference', 'like', '%' . request('query') . '%']
                    ])
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->toArray();
            } else {
                $orders = Order::select(['id', 'reference'])
                    ->where([
                        ['user_id', auth()->id()],
                        ['reference', 'like', '%' . request('query') . '%']
                    ])
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->toArray();
            }

            // Search for the orders placed by the user.
            

            // Search for the deliveries related to the user's company.
            $deliveries = auth()->user()->deliveries()
                ->with('order')
                ->where('reference', 'like', '%' . request('query') . '%')
                ->latest()
                ->limit(5)
                ->get()
                ->toArray();

            // Search for the user's own company.
            $companies = Company::select(['id', 'name', 'slug'])
                ->where([
                    ['id', auth()->user()->company_id],
                    ['name', 'like', '%' . request('query') . '%']
                ])
                ->get()
                ->toArray();

            // Show the businesses related the user's company
            if (auth()->user()->isPartOfACompany()) {
                $businesses = Business::select(['id', 'name', 'reference'])
                    ->where([
                        ['company_id', auth()->user()->company_id],
                        ['name', 'like', '%' . request('query') . '%']
                    ])
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->toArray();
            } else {
                $businesses = Business::select(['id', 'name', 'reference'])
                    ->where([
                        ['user_id', auth()->id()],
                        ['name', 'like', '%' . request('query') . '%']
                    ])
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->toArray();
            }

            // Search for the contacts related to the user.
            if (auth()->user()->isPartOfACompany()) {
                $contacts = Contact::select(['id', 'name'])
                    ->where([
                        ['company_id', auth()->user()->company->id],
                        ['name', 'like', '%' . request('query') . '%']
                    ])
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->toArray();
            } else {
                $contacts = Contact::select(['id', 'name'])
                    ->where([
                        ['user_id', auth()->id()],
                        ['name', 'like', '%' . request('query') . '%']
                    ])
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->toArray();
            }
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
