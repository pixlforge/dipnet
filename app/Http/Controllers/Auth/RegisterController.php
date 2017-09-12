<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Company;
use App\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationEmailConfirmation;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest')
            ->except('updateContact', 'updateCompany');
    }

    /**
     * Show the registration view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a new user account.
     */
    public function store()
    {
        $this->validateAccount();

        $company = $this->createDefaultCompany();
        $contact = $this->createDefaultContact($company->id);

        $user = $this->createAccount($company, $contact);

        $this->sendConfirmationEmail($user);

        return Auth::login($user, true);
    }

    /**
     * Validate the user account.
     */
    protected function validateAccount()
    {
        request()->validate([
            'username' => 'required|string|unique:users|min:2|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'username.required' => 'Veuillez entrer un nom d\'utilisateur.',
            'username.string' => 'Le nom d\'utilisateur doit être une chaîne de caractères.',
            'username.unique' => 'Ce nom d\'utilisateur est déjà utilisé.',
            'username.min' => 'Minimum 2 caractères.',
            'username.max' => 'Maximum 255 caractères.',
            'email.required' => 'Veuillez entrer une adresse e-mail.',
            'email.string' => 'L\'adresse e-mail doit être une chaîne de caractères.',
            'email.email' => 'L\'adresse e-mail doit correspondre au format utilisateur@fournisseur.tld.',
            'email.max' => 'Maximum 255 caractères.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
            'password.required' => 'Un mot de passe est requis.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Minimum 6 caractères.',
            'password.confirmed' => 'Les mots de passe ne concordent pas.'
        ]);
    }

    /**
     * Create the user account.
     *
     * @param $company
     * @param $contact
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    protected function createAccount($company, $contact)
    {
        return User::create([
            'username' => request('username'),
            'password' => bcrypt(request('password')),
            'role' => 'utilisateur',
            'email' => request('email'),
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'confirmation_token' => User::generateConfirmationToken(request('email'))
        ]);
    }


    /**
     * Create a default Company model to be associated with the user.
     *
     * @return mixed
     */
    protected function createDefaultCompany()
    {
        return factory('App\Company')
            ->states('default')
            ->create();
    }

    /**
     * Create a default Contact model to be associated with the user.
     *
     * @param $companyId
     * @return mixed
     */
    protected function createDefaultContact($companyId)
    {
        return factory('App\Contact')
            ->states('default')
            ->create(['company_id' => $companyId]);
    }

    /**
     * Update the user's contact information.
     *
     * @return $this|bool
     */
    public function updateContact()
    {
        $this->validateContact();

        $contact = Contact::where('id', auth()->user()->contact_id);

        $contact = $contact->update([
            'name' => request('name'),
            'address_line1' => request('address_line1'),
            'address_line2' => request('address_line2'),
            'zip' => request('zip'),
            'city' => request('city'),
            'phone_number' => request('phone_number'),
            'fax' => request('fax'),
            'email' => auth()->user()->email,
            'created_by_username' => auth()->user()->username
        ]);

        $this->confirmField('contact_confirmed');
    }

    /**
     * Update the user's company information.
     *
     * @return $this|bool
     */
    public function updateCompany()
    {
        $this->validateCompany();

        $company = Company::where('id', auth()->user()->company_id);

        if (request('name') !== 'self') {
            $company = $company->update([
                'name' => request('name'),
                'created_by_username' => auth()->user()->username
            ]);
        } else {
            $company = $company->update([
                'name' => auth()->user()->username,
                'created_by_username' => auth()->user()->username
            ]);
        }

        $this->confirmField('company_confirmed');
    }

    /**
     * Validate contact information.
     */
    protected function validateContact()
    {
        request()->validate([
            'name' => 'required|min:3|max:45',
            'address_line1' => 'required|min:3|max:255',
            'address_line2' => 'nullable|min:3|max:255',
            'zip' => 'required|min:4|max:16',
            'city' => 'required|min:3|max:45',
            'phone_number' => 'nullable|max:45',
            'fax' => 'nullable|max:45',
        ], [
            'name.required' => 'Veuillez entrer un nom.',
            'name.min' => 'Minimum 3 caractères.',
            'name.max' => 'Maximum 45 caractères.',
            'address_line1.required' => 'Veuillez entrer une adresse.',
            'address_line1.min' => 'Minimum 3 caractères.',
            'address_line1.max' => 'Maximum 255 caractères.',
            'address_line2.min' => 'Minimum 3 caractères.',
            'address_line2.max' => 'Maximum 255 caractères.',
            'zip.required' => 'Veuillez entrer un code postal.',
            'zip.min' => 'Le code postal doit être composé de 4 caractères au minimum.',
            'zip.max' => 'Le code postal doit être composé de 16 caractères au maximum.',
            'city.required' => 'Veuillez entrer une localité.',
            'city.min' => 'Minimum 2 caractères.',
            'city.max' => 'Maximum 45 caractères.',
            'phone_number.max' => 'Le n° de téléphone doit être composé de 45 caractères au maximum.',
            'fax.max' => 'Le n° de fax doit être composé de 45 caractères au maximum.'
        ]);
    }

    /**
     * Validate company information.
     */
    protected function validateCompany()
    {
        request()->validate([
            'name' => 'nullable|min:3|max:45|unique:companies,name'
        ], [
            'name.min' => 'Minimum 3 caractères.',
            'name.max' => 'Maximum 45 caractères.',
            'name.unique' => 'Cette société existe déjà. Demandez une invitation à une personne possédant un compte valide associé à cette société.'
        ]);
    }

    /**
     * Confirm the user has entered his contact and company information
     *
     * @param $field
     */
    protected function confirmField($field)
    {
        auth()->user()->$field = true;
        auth()->user()->save();
    }

    /**
     * @param $user
     */
    protected function sendConfirmationEmail($user)
    {
        Mail::to($user)
            ->queue(new RegistrationEmailConfirmation($user));
    }
}
