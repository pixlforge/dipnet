<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:45',
            'status' => 'required|in:temporaire,permanent',
            'description' => 'nullable|max:255'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Veuillez entrer un nom.',
            'name.min' => 'Minimum 3 caractères.',
            'name.max' => 'Maximum 45 caractères',

            'status.required' => 'Veuillez sélectionner un status.',
            'status.in' => 'Veuillez sélectionner un status parmi ceux proposés',
            
            'description.max' => 'Maximum 255 caractères.'
        ];
    }
}
