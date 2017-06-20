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
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Contact::class);

        $contacts = Contact::withTrashed()->with('company')->get()->sortBy('name');

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Contact::class);

        $companies = Company::all()->sortBy('name');

        return view('contacts.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContactRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        $this->authorize('create', Contact::class);

        Contact::create([
            'name' => request('name'),
            'address_line1' => request('address_line1'),
            'address_line2' => request('address_line2'),
            'zip' => request('zip'),
            'city' => request('city'),
            'phone_number' => request('phone_number'),
            'fax' => request('fax'),
            'email' => request('email'),
            'company_id' => request('company_id'),
            'created_by_username' => auth()->user()->username
        ]);

        return redirect()->route('contacts');
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
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        $this->authorize('update', $contact);

        $companies = Company::all()->sortBy('name');

        return view('contacts.edit', compact(['contact', 'companies']));
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

        return redirect()->route('contacts');
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

        return redirect()->route('contacts');
    }

    /**
     * Restores a previously soft deleted model.
     *
     * @param $contact
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($contact)
    {
        $this->authorize('restore', Contact::class);

        Contact::onlyTrashed()->where('id', $contact)->restore();

        return redirect()->route('contacts');
    }
}
