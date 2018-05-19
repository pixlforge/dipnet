<?php

namespace App\Http\Controllers\Contact;

use App\Company;
use App\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;

class ContactController extends Controller
{
    use SoftDeletes;

    /**
     * ContactController constructor.
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
     * Display a listing of the Contact model.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();

        return view('contacts.index', compact('companies'));
    }

    /**
     * Save a new Contact model.
     *
     * @param StoreContactRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreContactRequest $request)
    {
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->address_line1 = $request->address_line1;
        $contact->address_line2 = $request->address_line2;
        $contact->zip = $request->zip;
        $contact->city = $request->city;
        $contact->phone_number = $request->phone_number;
        $contact->fax = $request->fax;
        $contact->email = $request->email;

        if (auth()->user()->isAdmin()) {
            $contact->user_id = null;
            $contact->company_id = $request->company_id;
        } else if (auth()->user()->isNotAdmin() && auth()->user()->isPartOfACompany()) {
            $contact->user_id = auth()->id();
            $contact->company_id = auth()->user()->company->id;
        } else if (auth()->user()->isNotAdmin() && auth()->user()->isSolo()) {
            $contact->user_id = auth()->id();
            $contact->company_id = null;
        }

        $contact->save();

        $contact->load('company');

        return response($contact, 200);
    }

    /**
     * Display the specified Contact.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);

        return view('contacts.show', compact('contact'));
    }

    /**
     * Update the Contact.
     *
     * @param UpdateContactRequest $request
     * @param Contact $contact
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
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

        if (auth()->user()->isAdmin()) {
            $contact->company_id = $request->company_id;
        }

        $contact->save();


//        $contact->update([
//            'name' => $request->name,
//            'address_line1' => $request->address_line1,
//            'address_line2' => $request->address_line2,
//            'zip' => $request->zip,
//            'city' => $request->city,
//            'phone_number' => $request->phone_number,
//            'fax' => $request->fax,
//            'email' => $request->email,
//            'company_id' => $request->company_id
//        ]);

        return response($contact, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        return response(null, 204);
    }
}
