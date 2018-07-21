<?php

namespace App\Http\Controllers\Admin\Contact;

use App\Company;
use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $companies = Company::all();

        return view('admin.contacts.index', compact('companies'));
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
        $contact->company_id = $request->company_id;

        $contact->save();

        $contact->load('company');

        return response($contact, 200);
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
        $contact->company_id = $request->company_id;

        $contact->save();

        return response($contact, 200);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response(null, 204);
    }
}
