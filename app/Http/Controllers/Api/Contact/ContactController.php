<?php

namespace Dipnet\Http\Controllers\Api\Contact;

use Dipnet\Contact;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Http\Resources\ContactsCollection;

class ContactController extends Controller
{
    /**
     * ContactController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @return ContactsCollection
     */
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return new ContactsCollection(
                Contact::orderBy('name')
                    ->paginate(25)
            );
        } else if (auth()->user()->isNotSolo()) {
            return new ContactsCollection(
                Contact::where('company_id', auth()->user()->company->id)
                    ->orderBy('name')
                    ->paginate(25)
            );
        } else {
            // User is solo
        }
    }
}
