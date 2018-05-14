<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|min:3|max:255',
            'role' => 'required|in:utilisateur,administrateur',
            'email' => 'required|string|email|unique:users,id,:id|max:255',
            'contact_id' => 'nullable|exists:contacts,id',
            'company_id' => 'nullable|exists:companies,id',
            'password' => 'nullable|string|min:6|confirmed',
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
            'username.min' => 'Minimum 3 caractères.',
            'username.max' => 'Maximum 255 caractères.',
            'role.required' => 'Veuillez sélectionner un rôle.',
            'role.in' => 'Veuillez sélectionner un rôle parmi ceux proposés.',
            'email.required' => 'Veuillez entrer une adresse email.',
            'email.string' => 'L\'e-mail doit être une chaîne de caractères.',
            'email.email' => 'L\'e-mail doit correspondre au format compte@fournisseur.tld.',
            'email.unique' => 'Cette adresse est déjà utilisée.',
            'email.max' => 'Maximum 255 caractères.',
            'contact_id.exists' => 'Veuillez sélectionner un contact parmi ceux proposés.',
            'company_id.exists' => 'Veuillez sélectionner une société parmi celles proposées.'
        ];
    }
}
