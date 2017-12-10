<?php

namespace Dipnet\Http\Controllers\Auth;

use Dipnet\Contact;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Requests\Register\RegisterContactRequest;
use Dipnet\Invitation;

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
     * Create a new Contact model.
     *
     * @param RegisterContactRequest $request
     * @internal param null $registrationType
     */
    public function store(RegisterContactRequest $request)
    {
        Contact::create([
            'name' => $request->name,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'zip' => $request->zip,
            'city' => $request->city,
            'phone_number' => $request->phone_number,
            'fax' => $request->fax,
            'email' => auth()->user()->email,
            'user_id' => auth()->id()
        ]);

        if ($request->invitation_company) {
            auth()->user()->associateWithCompany($request->invitation_company);
            auth()->user()->associateContactWithCompany($request->invitation_company);
            auth()->user()->confirm();
        }

        auth()->user()->confirmCompany();
        auth()->user()->confirmContact();
    }
}