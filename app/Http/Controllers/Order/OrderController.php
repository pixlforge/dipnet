<?php

namespace App\Http\Controllers\Order;

use App\Order;
use App\Format;
use App\Contact;
use App\Article;
use App\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;

class OrderController extends Controller
{
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        $this->middleware([
            'auth',
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
        $orders = Order::where('user_id', auth()->id())
            ->with(['business', 'contact', 'user'])
            ->orderBy('created_at')
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Create
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(Order $order)
    {
        if (!$order->exists) {
            $order = $this->createSkeletonOrder();

            return redirect()->route('orders.create.end', $order);
        }

        $this->authorize('touch', $order);

        if (auth()->user()->hasCompany()) {
            $businesses = Business::where('company_id', auth()->user()->company_id)
                ->orderBy('name')
                ->get();

            $contacts = Contact::where('company_id', auth()->user()->company_id)
                ->orderBy('name')
                ->get();
        } else {
            // businesses related to the user's contacts
            // contacts created by the user
        }

        $deliveries = $this->getOrderDeliveries($order);
        $order = $order->load('business', 'contact');
        
        $articles = Article::all();

        return view('orders.create', [
            'order' => $order,
            'businesses' => $businesses, //ok
            'contacts' => $contacts, //ok
            'deliveries' => $deliveries,
            'documents' => $order->documents,
            'articles' => $articles //ok
        ]);
    }

    /**
     * Store a new Order.
     *
     * @param StoreOrderRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create([
            'reference' => uniqid(true),
            'user_id' => auth()->id()
        ]);

        return view('orders.create');
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
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->business_id = $request->business_id;
        $order->contact_id = $request->contact_id;
        $order->save();

        return response($order, 200);
    }

    /**
     * Delete an Order.
     *
     * @param $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        $order->delete();

        return response(null, 204);
    }

    /**
     * Create skeleton Order.
     *
     * @return mixed
     */
    protected function createSkeletonOrder()
    {
        return auth()->user()->orders()->create([
            'reference' => uniqid(true),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Get the deliveries associated with the Order model.
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