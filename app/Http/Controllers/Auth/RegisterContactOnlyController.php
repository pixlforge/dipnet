<?php

namespace App\Http\Controllers\Auth;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Register\RegisterContactRequest;

class RegisterContactOnlyController extends Controller
{
    /**
     * RegisterContactOnlyController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new solo user's contact.
     *
     * @param RegisterContactRequest $request
     */
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

        auth()->user()->confirmContact();
        auth()->user()->confirmCompany();
    }
}
