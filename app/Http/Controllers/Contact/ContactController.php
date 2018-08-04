<?php

namespace App\Http\Controllers\Contact;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\StoreUserContactRequest;
use App\Http\Requests\Contact\UpdateUserContactRequest;

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

    public function store(StoreUserContactRequest $request)
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
        
        if ($request->user()->isPartOfACompany()) {
            $contact->company()->associate(auth()->user()->company);
        } elseif ($request->user()->isSolo()) {
            $contact->user()->associate(auth()->id());
        }

        $contact->save();

        $contact->load('company');

        return response($contact, 200);
    }

    public function update(UpdateUserContactRequest $request, Contact $contact)
    {
        $this->authorize('update', $contact);

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
        $this->authorize('delete', $contact);

        $contact->delete();

        return response(null, 204);
    }
}
