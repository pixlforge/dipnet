<?php

namespace Dipnet\Http\Controllers\Api\Order;

use Dipnet\Order;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Resources\OrdersCollection;

class OrderController extends Controller
{
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

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
                Order::latest()
                    ->with('business', 'contact', 'user')
                    ->paginate(25)
            );
        }
    }
}
