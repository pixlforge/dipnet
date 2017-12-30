<?php

namespace Dipnet\Http\Controllers\Order;

use Dipnet\Document;
use Dipnet\Order;
use Dipnet\Format;
use Dipnet\Contact;
use Dipnet\Article;
use Dipnet\Business;
use Illuminate\Http\Request;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Requests\Order\StoreOrderRequest;
use Dipnet\Http\Requests\Order\UpdateOrderRequest;

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
        $this->middleware('user.email.confirmed')->except(['index']);
        $this->middleware('business')->only(['create']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $orders = Order::completed()->with(['business', 'contact', 'user'])
                ->orderBy('created_at')
                ->get();
        } else {
            $orders = Order::where('user_id', auth()->id())
                ->with(['business', 'contact', 'user'])
                ->orderBy('created_at')
                ->get();
        }

        return view('orders.index', [
            'orders' => $orders
        ]);
    }

    /**
     * Create
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Order $order)
    {
        // Create an order if none exist and redirect along with the newly created order.
        if (! $order->exists) {
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
            $contacts = auth()->user()->contacts;

            $contactIds = [];

            foreach ($contacts as $contact) {
                array_push($contactIds, $contact->id);
            }

            $businesses = Business::whereIn('contact_id', $contactIds)->get();
        }

        $deliveries = $this->getOrderDeliveries($order);
        $order = $order->load('business', 'contact');

        $articles = Article::all();

        $documents = $order->documents()->with('articles')->get();

        return view('orders.create', [
            'order' => $order,
            'businesses' => $businesses,
            'contacts' => $contacts,
            'deliveries' => $deliveries,
            'documents' => $documents,
            'articles' => $articles
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
        Order::create([
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Order $order)
    {
        $this->authorize('view', Order::class);

        $order = Order::with(['business', 'contact'])->find($order->id);

        $deliveries = $this->getOrderDeliveries($order);
        $articles = Article::all();
        $documents = $order->documents()->with('articles')->get();

        $contacts = Contact::all();
        $businesses = Business::all();

        return view('orders.show', [
            'order' => $order,
            'deliveries' => $deliveries,
            'articles' => $articles,
            'documents' => $documents,
            'businesses' => $businesses,
            'contacts' => $contacts
        ]);
    }

    /**
     * @param Request $request
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
     * @param Order $order
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
            'user_id' => auth()->id(),
            'business_id' => auth()->user()->company->business_id
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