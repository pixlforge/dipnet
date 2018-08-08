<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Veuillez entrer un nom d\'utilisateur.',
            'username.string' => 'Le nom d\'utilisateur doit être une chaîne de caractères.',
            'username.min' => 'Minimum 2 caractères.',
            'username.max' => 'Maximum 255 caractères.',

            'email.required' => 'Veuillez entrer une adresse e-mail.',
            'email.email' => 'L\'adresse e-mail doit correspondre au format utilisateur@fournisseur.tld.',
            'email.max' => 'Maximum 255 caractères.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',

            'password.required' => 'Un mot de passe est requis.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Minimum 6 caractères.',
            'password.confirmed' => 'Les mots de passe ne concordent pas.'
        ];
    }
}
