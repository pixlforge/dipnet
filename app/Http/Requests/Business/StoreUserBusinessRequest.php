<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserBusinessRequest extends FormRequest
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
            'contact_id' => 'nullable|exists:contacts,id',
            'folder_color' => 'required|in:red,orange,purple,blue'
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

            'contact_id.exists' => 'Veuillez sélectionner un contact parmi ceux proposés.',

            'folder_color.exists' => 'Veuillez sélectionner une couleur parmi celles proposées.',
        ];
    }
}
