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
            'name' => 'required|min:3|max:45',
            'reference' => 'nullable|unique:businesses,id,:id|min:3|max:45',
            'description' => 'nullable|max:45',
            'company_id' => 'nullable|exists:companies,id',
            'contact_id' => 'required|exists:contacts,id',
            'folder_color' => 'nullable|in:red,orange,purple,blue'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Veuillez entrer un nom pour l'affaire.",
            'name.min' => 'Minimum 3 caractères.',
            'name.max' => 'Maximum 45 caractères.',

            'reference.required' => 'Veuillez entrer une référence.',
            'reference.unique' => 'Cette référence est déjà utilisée.',
            'reference.min' => 'Minimum 3 caractères.',
            'reference.max' => 'Maximum 45 caractères.',

            'description.max' => 'Maximum 45 caractères.',

            'company_id.required' => 'Veuillez sélectionner une société.',
            'company_id.exists' => 'Veuillez sélectionner une société parmi celles proposées.',
            'contact_id.required' => 'Veuillez sélectionner un contact.',
            'contact_id.exists' => 'Veuillez sélectionner un contact.'
        ];
    }
}
