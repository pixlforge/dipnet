<?php

namespace App\Http\Controllers\Api\Order;

use App\Order;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrdersCollection;

class OrderController extends Controller
{
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Fetch orders.
     *
     * @return OrdersCollection
     */
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return new OrdersCollection(
                Order::latest()
                    ->completed()
                    ->with('business', 'contact', 'user')
                    ->paginate(25)
            );
        } else {
            return new OrdersCollection(
                Order::own()
                    ->orderBy('status', 'desc')
                    ->latest()
                    ->with('business', 'contact', 'user')
                    ->paginate(25)
            );
        }
    }
}
