<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyDefaultBusinessRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:45',
            'description' => 'nullable|string|max:45',
            'contact_id' => 'nullable|exists:contacts,id',
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
            'name.required' => "Veuillez entrer un nom pour l'affaire.",
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.min' => 'Minimum 3 caractères.',
            'name.max' => 'Maximum 45 caractères.',

            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'Maximum 45 caractères.',

            'contact_id.required' => 'Veuillez sélectionner un contact.',
            'contact_id.exists' => 'Veuillez sélectionner un contact parmi ceux proposés.',
        ];
    }
}
