<?php

namespace App\Http\Controllers\Api\Contact;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactsCollection;

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
                Contact::with('company')
                    ->orderBy('name')
                    ->paginate(25)
            );
        } else if (auth()->user()->isNotSolo()) {
            return new ContactsCollection(
                Contact::where('company_id', auth()->user()->company->id)
                    ->orderBy('name')
                    ->paginate(25)
            );
        } else {
            return new ContactsCollection(
                Contact::where('user_id', auth()->id())
                    ->orderBy('name')
                    ->paginate(25)
            );
        }
    }
}
