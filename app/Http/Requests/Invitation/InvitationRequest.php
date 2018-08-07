<?php

namespace App\Http\Requests\Invitation;

use Illuminate\Foundation\Http\FormRequest;

class InvitationRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|max:255|unique:invitations|unique:users'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Veuillez entrer une adresse e-mail.',
            'email.string' => 'L\'adresse e-mail doit être une chaîne de caractères.',
            'email.email' => 'L\'adresse e-mail doit correspondre au format utilisateur@fournisseur.tld.',
            'email.max' => 'Maximum 255 caractères.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.'
        ];
    }
}
