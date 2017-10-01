<?php

namespace App\Http\Controllers;

use App\User;
use App\Contact;
use App\Mail\InvitationEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InviteMemberController extends Controller
{
    /**
     * InviteMemberController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('confirm');
    }

    /**
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function store()
    {
        request()->validate([
            'email' => 'required|string|email|max:255|unique:users'
        ], [
            'email.required' => 'Veuillez entrer une adresse e-mail.',
            'email.string' => 'L\'adresse e-mail doit être une chaîne de caractères.',
            'email.email' => 'L\'adresse e-mail doit correspondre au format utilisateur@fournisseur.tld.',
            'email.max' => 'Maximum 255 caractères.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.'
        ]);

        $contact = factory('App\Contact')
            ->states('default')
            ->create([
                'name' => request('email'),
                'email' => request('email'),
                'company_id' => auth()->user()->company_id,
            ]);

        $user = User::create([
            'username' => request('email'),
            'password' => bcrypt(request('secret')),
            'role' => 'utilisateur',
            'email' => request('email'),
            'email_confirmed' => false,
            'confirmation_token' => User::generateConfirmationToken(request('email')),
            'company_id' => auth()->user()->company_id,
            'contact_confirmed' => false,
            'company_confirmed' => true,
            'was_invited' => true
        ]);

        Mail::to($user)
            ->queue(new InvitationEmail($user));

        if (request()->wantsJson()) {
            return $user;
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function confirm()
    {
        $user = User::where('confirmation_token', request('token'))->first();

        if (! $user) {
            return redirect()
                ->route('login')
                ->with('flash', 'La confirmation de votre compte a échoué. Le code de confirmation est invalide.')
                ->with('level', 'danger');
        }

        Auth::login($user, true);

        return view('account.details');
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function update(User $user)
    {
        request()->validate([
            'username' => 'required|string|unique:users|min:2|max:255',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'username.required' => 'Veuillez entrer un nom d\'utilisateur.',
            'username.string' => 'Le nom d\'utilisateur doit être une chaîne de caractères.',
            'username.unique' => 'Ce nom d\'utilisateur est déjà utilisé.',
            'username.min' => 'Minimum 2 caractères.',
            'username.max' => 'Maximum 255 caractères.',
            'password.required' => 'Un mot de passe est requis.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Minimum 6 caractères.',
            'password.confirmed' => 'Les mots de passe ne concordent pas.'
        ]);

        $user = User::where('id', auth()->id())->first();

        $user->update([
            'username' => request('username'),
            'password' => bcrypt(request('password'))
        ]);

        $user->confirm();

        if (request()->expectsJson()) {
            return response([], 204);
        }
    }
}