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
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $companies = Company::orderBy('name')->get();

        return view('admin.users.index', compact('companies'));
    }

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

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->username = $request->username;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->email_confirmed = $this->getEmailStatus($user->email_confirmed);
        
        if ($request->role === 'administrateur') {
            $user->company_id = null;
            $user->is_solo = false;
        } elseif ($user->isNotSolo() && $request->has('company_id')) {
            $user->company_id = $request->company_id;
            $user->is_solo = false;
        } elseif ($user->isNotSolo() && !$request->has('company_id')) {
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

        return response($user, 200);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return response(null, 204);
    }

    protected function getEmailStatus($status): int
    {
        if ($status == 1 && empty($request->email_confirmed)) {
            $emailStatus = 1;
        } else {
            $emailStatus = 0;
        }
        return $emailStatus;
    }

    protected function sendConfirmationEmail($user)
    {
        Mail::to($user)
            ->queue(new RegistrationEmailConfirmation($user));
    }
}
