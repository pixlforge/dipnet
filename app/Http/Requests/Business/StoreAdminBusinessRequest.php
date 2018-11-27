<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminBusinessRequest extends FormRequest
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
            'description' => 'nullable|string|max:255',
            'user_id' => 'required_without:company_id|nullable|exists:users,id',
            'company_id' => 'required_without:user_id|nullable|exists:companies,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'folder_color' => 'nullable|in:red,orange,purple,blue'
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
            'description.max' => 'Maximum 255 caractères.',

            'user_id.required_without' => 'Veuillez sélectionner un utilisateur ou une société.',
            'user_id.exists' => 'Veuillez sélectionner un utilisateur parmi ceux proposés.',

            'company_id.required_without' => 'Veuillez sélectionner une société ou un utilisateur.',
            'company_id.exists' => 'Veuillez sélectionner une société parmi celles proposées.',

            'contact_id.exists' => 'Veuillez sélectionner un contact parmi ceux proposés.',

            'folder_color.exists' => 'Veuillez sélectionner une couleur parmi celles proposées.',
        ];
    }
}
