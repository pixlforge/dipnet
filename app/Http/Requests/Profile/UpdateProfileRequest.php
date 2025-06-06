<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            'username' => 'required|string|min:3|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'email' => [
                'nullable',
                'email',
                Rule::unique('users')->ignore($this->id)
            ]
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
            'username.required' => "Le nom d'utilisateur est requis.",
            'username.string' => "Le nom d'utilisateur doit être une chaîne de caractères.",
            'username.min' => 'Minimum 3 caractères.',
            'username.max' => 'Maximum 255 caractères.',
    
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Minimum 6 caractères.',
            'password.confirmed' => 'Les mots de passe doivent correspondre.',

            'email.required' => "L'adresse email est requise.",
            'email.email' => "L'adresse email doit avoir le format adresse@email.ch.",
            'email.unique' => 'Cette adresse email est déjà utilisée.',
        ];
    }
}
