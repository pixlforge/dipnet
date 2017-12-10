<?php

namespace Dipnet\Http\Requests\Register;

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
            'username' => 'required|string|unique:users|min:2|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ];
    }

    /**
     * Validation error messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
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
        ];
    }
}
