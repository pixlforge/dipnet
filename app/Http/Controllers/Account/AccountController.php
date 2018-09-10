<?php

namespace App\Http\Controllers\Account;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserUpdatedEmailAddress;
use App\Http\Requests\Profile\UpdateProfileRequest;

class AccountController extends Controller
{
    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the account add contact page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact()
    {
        return view('account.contact');
    }

    /**
     * Display the account add company page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function company()
    {
        return view('account.company');
    }

    /**
     * Update the user's account.
     *
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $user->username = $request->username;

        if ($request->has('email') && !is_null($request->email) && $user->email !== $request->email) {
            $user->email = $request->email;
            $user->email_confirmed = false;
            $user->confirmation_token = User::generateConfirmationToken($request->email);

            $user->save();

            Mail::to($request->email)
                ->queue(new UserUpdatedEmailAddress($user));
        }

        if ($request->has('password') && !is_null($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response($user, 200);
    }
}
