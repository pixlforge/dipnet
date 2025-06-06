<?php

namespace App\Http\Controllers\Profiles;

use App\Contact;
use App\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware([
            'auth',
            'user.account.contact',
            'user.account.company'
        ]);
    }

    /**
     * Display the the current user's profile.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Profile::class);

        $contacts = Contact::where('company_id', auth()->user()->company->id)->orderBy('first_name')->get();

        $ordersCount = auth()->user()->orders_count;

        $businessesCount = auth()->user()->businesses_count;

        return view('profiles.profile', [
            'contacts' => $contacts,
            'orders' => $ordersCount,
            'businesses' => $businessesCount
        ]);
    }

    /**
     * Set the user's avatar.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request)
    {
        if ($request->avatar['id']) {
            auth()->user()->avatar_id = $request->avatar['id'];
            auth()->user()->save();
        }

        return response([], 200);
    }
}
