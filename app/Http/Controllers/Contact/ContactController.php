<?php

namespace App\Http\Controllers\Contact;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\StoreUserContactRequest;
use App\Http\Requests\Contact\UpdateUserContactRequest;

class ContactController extends Controller
{
    /**
     * ContactController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.email.confirmed');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('contacts.index');
    }

    /**
     * @param StoreUserContactRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * @param UpdateUserContactRequest $request
     * @param Contact $contact
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
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

    /**
     * @param Contact $contact
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        return response(null, 204);
    }
}
