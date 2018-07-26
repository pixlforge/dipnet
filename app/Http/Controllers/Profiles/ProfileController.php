<?php

namespace App\Http\Controllers\Profiles;

use App\Contact;
use App\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth',
            'user.account.contact',
            'user.account.company'
        ]);
    }

    public function index()
    {
        $this->authorize('view', Profile::class);

        $contacts = Contact::where('company_id', auth()->user()->company->id)
            ->orderBy('name')
            ->get();

        $ordersCount = auth()->user()->orders_count;

        $businessesCount = auth()->user()->businesses_count;

        return view('profiles.profile', [
            'contacts' => $contacts,
            'orders' => $ordersCount,
            'businesses' => $businessesCount
        ]);
    }

    public function update(Request $request)
    {
        if ($request->avatar['id']) {
            auth()->user()->avatar_id = $request->avatar['id'];
            auth()->user()->save();
        }

        return response([], 200);
    }
}
