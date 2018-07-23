<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:45',
            'description' => 'nullable|string|max:45',
            'user_id' => 'required_without:company_id|exists:users,id',
            'company_id' => 'required_without:user_id|exists:companies,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'folder_color' => 'nullable|in:red,orange,purple,blue'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Veuillez entrer un nom pour l'affaire.",
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.min' => 'Minimum 3 caractères.',
            'name.max' => 'Maximum 45 caractères.',

            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'Maximum 45 caractères.',

            'company_id.required' => 'Veuillez sélectionner une société.',
            'company_id.exists' => 'Veuillez sélectionner une société parmi celles proposées.',

            'contact_id.required' => 'Veuillez sélectionner un contact.',
            'contact_id.exists' => 'Veuillez sélectionner un contact parmi ceux proposés.',
        ];
    }
}
