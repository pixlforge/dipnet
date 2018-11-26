<?php

namespace App\Http\Controllers\Order;

use App\Order;
use App\Contact;
use App\Article;
use App\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Hashids\HashidsGenerator;

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
            'user.account.company',
        ]);
        $this->middleware('user.email.confirmed')->except('index');
        $this->middleware('business')->only('create');
    }

    /**
     * Display a list of the user's own orders.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('orders.index');
    }

    /**
     * Store a new order and associate it with the user.
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Order $order)
    {
        abort_if(auth()->user()->isAdmin(), 403, "Vous n'êtes pas autorisé à accéder à cette ressource.");
        
        // Create an order if none exist and redirect along with the newly created order.
        if (!$order->exists) {
            $order = $this->createSkeletonOrder();
            return redirect()->route('orders.create.end', $order);
        }

        abort_if($order->status !== 'incomplète', 403, "Vous n'êtes pas autorisé à accéder à cette ressource.");

        $this->authorize('touch', $order);

        if (auth()->user()->isAdmin()) {
            $businesses = Business::all();
            $contacts = Contact::all();
        } elseif (auth()->user()->isPartOfACompany()) {
            $businesses = Business::where('company_id', auth()->user()->company_id)->orderBy('name')->get();
            $contacts = Contact::where('company_id', auth()->user()->company_id)->orderBy('first_name', 'last_name')->get();
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

        $documents = $order->documents()->with(['media', 'articles' => function ($query) {
            $query->orderBy('description');
        }])->get();
        
        return view('orders.create', compact('order', 'businesses', 'contacts', 'deliveries', 'documents', 'articles'));
    }

    /**
     * Update an existing order's details.
     *
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->status = $request->status;
        $order->business_id = $request->business_id;
        $order->contact_id = $request->contact_id;

        if (auth()->user()->isAdmin()) {
            $order->managedBy()->associate(auth()->id());
        }

        $order->save();

        return response($order, 200);
    }

    public function destroy(Order $order)
    {
        $this->authorize('touch', $order);

        abort_if($order->status !== 'incomplète', 403, "Vous n'êtes pas autorisé à faire cela.");

        foreach ($order->documents as $document) {
            if ($document->hasMedia('documents')) {
                $media = $document->getFirstMedia('documents');
                $media->delete();
            }
        }

        $order->deliveries->each->delete();

        $order->delete();

        return response(null, 204);
    }

    /**
     * Create the base order.
     *
     * @return Order
     */
    protected function createSkeletonOrder()
    {
        $order = new Order;
        $order->user_id = auth()->id();
        $order->business_id = auth()->user()->company->business_id;
        $order->company_id = auth()->user()->company->id;
        $order->save();
        
        $order->reference = HashidsGenerator::generateFor($order->id, 'orders');
        $order->save();

        return $order;
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
