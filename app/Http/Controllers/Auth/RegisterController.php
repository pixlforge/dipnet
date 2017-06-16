<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Contact;
use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|unique:users|min:2|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $company = Company::create([
            'name' => $data['username'] . ' (Default)',
            'status' => 'temporaire',
            'created_by_username' => $data['username']
        ]);

//        dd($company);

        $contact = Contact::create([
            'name' => $data['username'] . ' (Default)',
            'address_line1' => $data['address_line1'],
            'address_line2' => $data['address_line2'],
            'zip' => $data['zip'],
            'city' => $data['city'],
            'phone_number' => $data['phone_number'],
            'fax' => $data['fax'],
            'email' => $data['email'],
            'company_id' => $company->id,
            'created_by_username' => $data['username']
        ]);

//        dd($contact);

        return User::create([
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'role' => 'user',
            'email' => $data['email'],
            'email_validated' => 0,
            'contact_id' => $contact->id,
            'company_id' => $company->id
        ]);

//        return [$user, $contact, $company];

//        return User::create([
//            'username' => $data['username'],
//            'role' => 'user',
//            'email' => $data['email'],
//            'password' => bcrypt($data['password'])
//        ]);
    }
}
