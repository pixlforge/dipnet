<?php

namespace App\Http\Controllers\Orders;

use App\Order;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    /**
     * OrdersController constructor.
     */
    public function __construct()
    {
        $this->middleware([
            'auth',
            'user.account.details',
            'user.account.contact',
            'user.account.company'
        ]);
        $this->middleware('user.email.confirmed')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Order::class);

        if (auth()->user()->role == 'administrateur') {
            $orders = Order::with(['business', 'contact', 'user'])
                ->orderBy('created_at')
                ->get();
        } else {
            $orders = Order::where('user_id', auth()->user()->id)
                ->with(['business', 'contact', 'user'])
                ->orderBy('created_at')
                ->get();
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
//        $this->authorize('create', Order::class);

        $order = Order::create([
            'reference' => request('reference'),
            'status' => request('status'),
            'business_id' => request('business_id'),
            'contact_id' => request('contact_id'),
            'user_id' => auth()->id()
        ]);

        if (request()->expectsJson()) {
            return $order->id;
        }

        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return view('orders.show', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderRequest $request
     * @param $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, Order $order)
    {
        $this->authorize('update', $order);

        $order->update([
            'reference' => request('reference'),
            'status' => request('status'),
            'business_id' => request('business_id'),
            'contact_id' => request('contact_id')
        ]);

        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        $order->delete();

        return redirect()->route('orders.index');
    }
}