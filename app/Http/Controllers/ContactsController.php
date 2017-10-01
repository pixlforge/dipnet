<?php

namespace App\Http\Controllers;

use App\Company;
use App\Contact;
use App\Http\Requests\ContactRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    use SoftDeletes;

    /**
     * ContactsController constructor.
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
        // User is authorized to access this resource
        $this->authorize('view', Contact::class);

        // Request every model if the user is an admin,
        // request only the related models otherwise.
        if (auth()->user()->role == 'administrateur') {
            $contacts = Contact::latest()
                ->with('company')
                ->orderBy('name')
                ->get()
                ->toJson();
        } else {
            $contacts = Contact::where('company_id', auth()->user()->company_id)
                ->with('company')
                ->latest()
                ->orderBy('name')
                ->get()
                ->toJson();
        }

        // Models are requested through Axios
        if (request()->wantsJson()) {
            return $contacts;
        }

        // Display view
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Persist a new Contact model.
     *
     * @param ContactRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContactRequest $request)
    {
        $this->authorize('create', Contact::class);

        $contact = Contact::create([
            'name' => $request->name,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'zip' => $request->zip,
            'city' => $request->city,
            'phone_number' => $request->phone_number,
            'fax' => $request->fax,
            'email' => $request->email,
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id
        ]);

        if (request()->expectsJson()) {
            return $contact->id;
        }

        return redirect()->route('contacts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);

        return view('contacts.show', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContactRequest $request
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        $contact->update([
            'name' => request('name'),
            'address_line1' => request('address_line1'),
            'address_line2' => request('address_line2'),
            'zip' => request('zip'),
            'city' => request('city'),
            'phone_number' => request('phone_number'),
            'fax' => request('fax'),
            'email' => request('email'),
            'company_id' => request('company_id')
        ]);

        if (request()->expectsJson()) {
            return response([], 204);
        }

        return redirect()->route('contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect()->route('contacts.index');
    }
}
