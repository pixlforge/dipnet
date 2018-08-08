<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return mixed
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
            'name' => 'required|string|min:3|max:45',
            'status' => 'required|string|in:temporaire,permanent',
            'description' => 'nullable|string|max:255'
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
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.min' => 'Minimum 3 caractères.',
            'name.max' => 'Maximum 45 caractères',

            'status.required' => 'Veuillez sélectionner un statut.',
            'status.string' => 'Le statut doit être une chaîne de caractères.',
            'status.in' => 'Veuillez sélectionner un status parmi ceux proposés',
            
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'Maximum 255 caractères.'
        ];
    }
}
