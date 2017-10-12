<?php

namespace App\Http\Controllers\Profiles;

use App\User;
use App\Company;
use App\Contact;
use App\Profile;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;

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
     * Profile
     */
    public function index()
    {
        $this->authorize('view', Profile::class);

        $user = User::select([
            'id',
            'username',
            'email',
            'email_confirmed',
            'company_id',
            'created_at'
        ])->where('id', auth()->id())
            ->firstOrFail();

        $users = User::where('company_id', $user->company->id)
            ->get()
            ->sortBy('username');

        $contacts = Contact::where('company_id', $user->company->id)
            ->get()
            ->sortBy('name');

        $ordersCount = auth()->user()->orders_count;

        $businessesCount = auth()->user()->businesses_count;

        return view('profiles.profile', [
            'user' => $user,
            'users' => $users,
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