<?php

namespace App\Http\Controllers\Auth;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Register\RegisterContactRequest;

class RegisterContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(RegisterContactRequest $request)
    {
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->address_line1 = $request->address_line1;
        $contact->address_line2 = $request->address_line2;
        $contact->zip = $request->zip;
        $contact->city = $request->city;
        $contact->phone_number = $request->phone_number;
        $contact->fax = $request->fax;
        $contact->email = auth()->user()->email;
        $contact->user_id = auth()->id();
        $contact->save();

        if ($request->invitation_company) {
            auth()->user()->associateWithCompany($request->invitation_company);
            auth()->user()->associateContactWithCompany($request->invitation_company);
            auth()->user()->confirm();
        }

        auth()->user()->confirmCompany();
        auth()->user()->confirmContact();
    }
}
