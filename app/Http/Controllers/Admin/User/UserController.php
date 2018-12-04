<?php

namespace App\Http\Controllers\Admin\User;

use App\User;
use App\Company;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Mail\RegistrationEmailConfirmation;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a list of all users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $companies = Company::orderBy('name')->get();

        return view('admin.users.index', compact('companies'));
    }

    /**
     * Show a user.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $user->load('company', 'avatar');

        $companies = Company::all();

        return view('admin.users.show', compact('user', 'companies'));
    }

    /**
     * Store a new user.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = new User;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->email = $request->email;
        $user->email_confirmed = $this->getEmailStatus($request->status);
        $user->confirmation_token = User::generateConfirmationToken($request->email);

        if ($request->role === 'administrateur') {
            $user->is_solo = false;
        } elseif ($request->role === 'utilisateur' && $request->company_id) {
            $user->company_id = $request->company_id;
            $user->company_confirmed = true;
        } else {
            $user->is_solo = true;
        }

        $user->save();

        $this->sendConfirmationEmail($user);

        return response($user, 200);
    }

    /**
     * Update an existing user.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->username = $request->username;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->email_confirmed = $this->getEmailStatus($user->email_confirmed);
        
        if ($request->role === 'administrateur') {
            $user->company_id = null;
            $user->is_solo = false;
        } elseif ($user->isPartOfACompany() && $request->has('company_id')) {
            $user->company_id = $request->company_id;
            $user->is_solo = false;
        } elseif ($user->isPartOfACompany() && !$request->has('company_id')) {
            $user->company_id = null;
            $user->is_solo = true;
        } elseif ($user->isSolo() && $request->has('company_id')) {
            $user->company_id = $request->company_id;
            $user->is_solo = false;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        $user->load('company');

        return response($user, 200);
    }

    /**
     * Delete an existing user.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return response(null, 204);
    }

    /**
     * Get the email status.
     *
     * @param $status
     * @return int
     */
    protected function getEmailStatus($status): int
    {
        if ($status == 1 && empty($request->email_confirmed)) {
            $emailStatus = 1;
        } else {
            $emailStatus = 0;
        }
        return $emailStatus;
    }

    /**
     * Send a confirmation email to the user.
     *
     * @param $user
     */
    protected function sendConfirmationEmail($user)
    {
        Mail::to($user)
            ->queue(new RegistrationEmailConfirmation($user));
    }
}
