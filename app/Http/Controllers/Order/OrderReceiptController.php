<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Order;

class OrderReceiptController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function show(Order $order)
    {
        $company = $order->business->company;
        $user = $order->user;
        $order->load('managedBy');

        return view('orders.receipts.show', [
            'order' => $order,
            'company' => $company,
            'user' => $user
        ]);
    }
}
