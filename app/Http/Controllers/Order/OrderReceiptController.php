<?php

namespace App\Http\Controllers\Order;

use App\Order;
use App\Http\Controllers\Controller;

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

        return view('orders.receipts.show', compact('order', 'company', 'user'));
    }
}
