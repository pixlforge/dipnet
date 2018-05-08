<?php

namespace Dipnet\Http\Controllers\User;

use Dipnet\User;
use Dipnet\Company;
use Illuminate\Support\Facades\Mail;
use Dipnet\Http\Controllers\Controller;
use Dipnet\Mail\RegistrationEmailConfirmation;
use Dipnet\Http\Requests\User\StoreUserRequest;
use Dipnet\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::orderBy('name')->get();

        return view('users.index', [
            'companies' => $companies
        ]);
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

        if ($request->role === 'administrateur') {
            $user->is_solo = false;
        } else if ($request->role === 'utilisateur' && $request->company_id) {
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
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('users.show', compact('user'));
    }

    /**
     * Update a user.
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
        } else if ($user->isNotSolo() && $request->company_id === null) {
            $user->company_id = null;
            $user->is_solo = true;
        } else if ($user->isSolo() && $request->company_id !== null) {
            $user->company_id = $request->company_id;
            $user->is_solo = false;
        } else {
            $user->company_id = $request->company_id;
        }

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response($user, 200);
    }

    /**
     * Delete the User.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return response(null, 204);
    }

    /**
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
     * Send a confirmation email to a newly registered user.
     *
     * @param $user
     */
    protected function sendConfirmationEmail($user)
    {
        Mail::to($user)
            ->queue(new RegistrationEmailConfirmation($user));
    }
}