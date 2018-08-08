<?php

namespace App\Http\Controllers\Order;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderStatusController extends Controller
{
    /**
     * OrderStatusController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Update the order's details and set the current admin as the manager.
     *
     * @param Order $order
     * @param Request $request
     */
    public function update(Order $order, Request $request)
    {
        $order->status = $request->status;
        $order->manager_id = auth()->id();
        $order->save();
    }
}
