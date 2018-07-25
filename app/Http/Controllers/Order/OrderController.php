<?php

namespace App\Http\Controllers\Order;

use App\Order;
use App\Format;
use App\Contact;
use App\Article;
use App\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Hashids\HashidsGenerator;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.account.contact');
        $this->middleware('user.account.company');
        $this->middleware('user.email.confirmed')->except('index');
        $this->middleware('business')->only('create');
    }

    public function index()
    {
        return view('orders.index');
    }

    public function create(Order $order)
    {
        // Create an order if none exist and redirect along with the newly created order.
        if (!$order->exists) {
            $order = $this->createSkeletonOrder();

            return redirect()->route('orders.create.end', $order);
        }

        $this->authorize('touch', $order);

        if (auth()->user()->isAdmin()) {
            $businesses = Business::all();
            $contacts = Contact::all();
        } elseif (auth()->user()->hasCompany()) {
            $businesses = Business::where('company_id', auth()->user()->company_id)->orderBy('name')->get();
            $contacts = Contact::where('company_id', auth()->user()->company_id)->orderBy('name')->get();
        } elseif (auth()->user()->isSolo()) {
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

    public function show(Order $order)
    {
        $this->authorize('view', Order::class);

        $order = Order::with(['business', 'contact'])->find($order->id);

        $deliveries = $this->getOrderDeliveries($order);
        $articles = Article::all();
        $documents = $order->documents()->with('articles')->get();

        $contacts = Contact::all();
        $businesses = Business::all();
        $formats = Format::all();

        return view('orders.show', [
            'order' => $order,
            'deliveries' => $deliveries,
            'articles' => $articles,
            'documents' => $documents,
            'businesses' => $businesses,
            'contacts' => $contacts,
            'formats' => $formats
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $order->business_id = $request->business_id;
        $order->contact_id = $request->contact_id;
        $order->save();

        return response($order, 200);
    }

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

    protected function getOrderDeliveries(Order $order)
    {
        $deliveries = $order->deliveries()->with('contact')->where('order_id', $order->id)->get();

        return $deliveries;
    }
}
