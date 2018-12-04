<?php

namespace App\Http\Controllers\Admin\Order;

use App\Order;
use App\Format;
use App\Article;
use App\Contact;
use App\Business;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show an order only visible to admins.
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Order $order)
    {
        $this->authorize('view', Order::class);

        $order = Order::with('business', 'contact')->find($order->id);

        $deliveries = $this->getOrderDeliveries($order);
        $articles = Article::withTrashed()->get();
        $documents = $order->documents()->with('articles', 'media')->get();

        $contacts = Contact::all();
        $businesses = Business::withTrashed()->get();
        $formats = Format::withTrashed()->get();

        return view('admin.orders.show', compact('order', 'deliveries', 'articles', 'documents', 'businesses', 'contacts', 'formats'));
    }

    /**
     * Get the order's deliveries.
     *
     * @param Order $order
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getOrderDeliveries(Order $order)
    {
        $deliveries = $order->deliveries()->with('contact')->where('order_id', $order->id)->get();

        return $deliveries;
    }
}
