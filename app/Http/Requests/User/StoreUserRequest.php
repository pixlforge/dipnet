<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'username' => 'required|string|min:3|max:255',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:utilisateur,administrateur',
            'email' => 'required|email|unique:users,id,:id|max:255',
            'company_id' => 'nullable|exists:companies,id'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Veuillez entrer un nom d\'utilisateur.',
            'username.string' => 'Le nom d\'utilisateur doit être une chaîne de caractères.',
            'username.min' => 'Minimum 3 caractères.',
            'username.max' => 'Maximum 255 caractères.',

            'password.required' => 'Un mot de passe est requis.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Minimum 6 caractères.',
            'password.confirmed' => 'Les mots de passe ne concordent pas.',

            'role.required' => 'Veuillez sélectionner un rôle.',
            'role.in' => 'Veuillez sélectionner un rôle parmi ceux proposés.',

            'email.required' => 'Veuillez entrer une adresse email.',
            'email.email' => 'L\'e-mail doit correspondre au format compte@fournisseur.tld.',
            'email.unique' => 'Cette adresse est déjà utilisée.',
            'email.max' => 'Maximum 255 caractères.',

            'company_id.exists' => 'Veuillez sélectionner une société parmi celles proposées.'
        ];
    }
}
