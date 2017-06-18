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
        return $this->createAccount($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    protected function createRelatedCompany(array $data)
    {
        $companyName = $this->getCompanyName($data);

        $company = Company::create([
            'name' => $companyName,
            'status' => 'temporaire',
            'created_by_username' => $data['username']
        ]);

        return $company;
    }

    /**
     * @param array $data
     * @param $company
     * @return mixed
     */
    protected function createRelatedContact(array $data, $company)
    {
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
        return $contact;
    }

    /**
     * @param array $data
     * @param $contact
     * @param $company
     * @return mixed
     */
    protected function registerUser(array $data, $contact, $company)
    {
        return User::create([
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'role' => 'utilisateur',
            'email' => $data['email'],
            'email_validated' => false,
            'contact_id' => $contact->id,
            'company_id' => $company->id
        ]);
    }

    /**
     * @param array $data
     * @return mixed
     */
    protected function createAccount(array $data)
    {
        $company = $this->createRelatedCompany($data);

        $contact = $this->createRelatedContact($data, $company);

        return $this->registerUser($data, $contact, $company);
    }

    /**
     * @param array $data
     * @return mixed
     */
    protected function getCompanyName(array $data)
    {
        if (isset($data['name'])) return $companyName = $data['name'];

        return $companyName = $data['username'] . ' (Default)';
    }
}
