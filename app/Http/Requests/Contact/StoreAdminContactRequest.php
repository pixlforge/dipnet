<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminContactRequest extends FormRequest
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
            'first_name' => 'required|string|min:2|max:45',
            'last_name' => 'required|string|min:2|max:45',
            'company_name' => 'nullable|string|min:2|max:45',
            'address_line1' => 'required|string|min:3|max:255',
            'address_line2' => 'nullable|string|min:3|max:255',
            'zip' => 'required|string|min:4|max:16',
            'city' => 'required|string|min:2|max:255',
            'phone_number' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'company_id' => 'nullable|exists:companies,id'
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
            'first_name.required' => 'Veuillez entrer un prénom.',
            'first_name.string' => 'Le prénom doit être une chaîne de caractères.',
            'first_name.min' => 'Minimum 2 caractères.',
            'first_name.max' => 'Maximum 45 caractères.',
            
            'last_name.required' => 'Veuillez entrer un nom.',
            'last_name.string' => 'Le nom doit être une chaîne de caractères.',
            'last_name.min' => 'Minimum 2 caractères.',
            'last_name.max' => 'Maximum 45 caractères.',

            'company_name.string' => 'Le nom doit être une chaîne de caractères.',
            'company_name.min' => 'Minimum 2 caractères.',
            'company_name.max' => 'Maximum 45 caractères.',

            'address_line1.required' => 'Veuillez entrer une adresse.',
            'address_line1.string' => "L'adresse doit être une chaîne de caractères.",
            'address_line1.min' => 'Minimum 2 caractères.',
            'address_line1.max' => 'Maximum 255 caractères.',

            'address_line2.string' => "L'adresse secondaire doit être une chaîne de caractères.",
            'address_line2.min' => 'Minimum 2 caractères.',
            'address_line2.max' => 'Maximum 255 caractères.',

            'zip.required' => 'Veuillez entrer un code postal.',
            'zip.string' => 'Le code postal doit être une chaîne de caractères.',
            'zip.min' => 'Le code postal doit être composé de 4 caractères au minimum.',
            'zip.max' => 'Le code postal doit être composé de 16 caractères au maximum.',

            'city.required' => 'Veuillez entrer une localité.',
            'city.string' => 'La ville doit être une chaîne de caractères.',
            'city.min' => 'Minimum 2 caractères.',
            'city.max' => 'Maximum 255 caractères.',

            'phone_number.string' => 'Le n° de téléphone doit être une chaîne de caractères.',
            'phone_number.max' => 'Le n° de téléphone doit être composé de 255 caractères au maximum.',

            'email.email' => 'Le format doit être du type adresse@email.com.',
            'email.max' => 'Maximum 255 caractères.',

            'company_id.exists' => 'Veuillez sélectionner une société parmi celles proposées.'
        ];
    }
}
