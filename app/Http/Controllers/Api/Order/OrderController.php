<?php

namespace App\Http\Controllers\Api\Order;

use App\Order;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrdersCollection;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
                Order::own()
                    ->latest()
                    ->with('business', 'contact', 'user')
                    ->paginate(25)
            );
        }
    }
}
