<?php

namespace App\Http\Controllers\Contact;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.email.confirmed');
    }

    public function index()
    {
        return view('contacts.index');
    }

    public function store(StoreContactRequest $request)
    {
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->address_line1 = $request->address_line1;
        $contact->address_line2 = $request->address_line2;
        $contact->zip = $request->zip;
        $contact->city = $request->city;
        $contact->phone_number = $request->phone_number;
        $contact->fax = $request->fax;
        $contact->email = $request->email;
        $contact->user_id = auth()->id();

        if ($request->user()->isPartOfACompany()) {
            $contact->company_id = auth()->user()->company->id;
        } elseif ($request->user()->isSolo()) {
            $contact->company_id = null;
        }

        $contact->save();

        $contact->load('company');

        return response($contact, 200);
    }

    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contact->name = $request->name;
        $contact->address_line1 = $request->address_line1;
        $contact->address_line2 = $request->address_line2;
        $contact->zip = $request->zip;
        $contact->city = $request->city;
        $contact->phone_number = $request->phone_number;
        $contact->fax = $request->fax;
        $contact->email = $request->email;

        $contact->save();

        return response($contact, 200);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response(null, 204);
    }
}
