<?php

namespace App\Http\Controllers\Auth;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Register\RegisterContactRequest;

class RegisterContactController extends Controller
{
    /**
     * RegisterContactController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new contact and update the user's account status.
     *
     * @param RegisterContactRequest $request
     */
    public function store(RegisterContactRequest $request)
    {
        $contact = new Contact;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->company_name = $request->company_name;
        $contact->address_line1 = $request->address_line1;
        $contact->address_line2 = $request->address_line2;
        $contact->zip = $request->zip;
        $contact->city = $request->city;
        $contact->phone_number = $request->phone_number;
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
