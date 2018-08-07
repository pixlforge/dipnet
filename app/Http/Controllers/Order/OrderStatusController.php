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
