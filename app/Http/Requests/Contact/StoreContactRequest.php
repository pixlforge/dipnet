<?php

namespace Dipnet\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:45',
            'address_line1' => 'required',
            'address_line2' => 'nullable',
            'zip' => 'required|numeric|min:1000|max:999999',
            'city' => 'required|min:2|max:45',
            'phone_number' => 'nullable|numeric|max:45',
            'fax' => 'nullable|numeric|max:45',
            'email' => 'required|email|max:45',
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
            'name.required' => 'Veuillez entrer un nom.',
            'name.min' => 'Minimum 3 caractères.',
            'name.max' => 'Maximum 45 caractères.',
            'address_line1.required' => 'Veuillez entrer une adresse.',
            'zip.required' => 'Veuillez entrer un code postal.',
            'zip.min' => 'Le code postal doit être composé de 4 caractères au minimum.',
            'zip.max' => 'Le code postal doit être composé de 16 caractères au maximum.',
            'city.required' => 'Veuillez entrer une localité.',
            'city.min' => 'Minimum 2 caractères.',
            'city.max' => 'Maximum 45 caractères.',
            'phone_number.max' => 'Le n° de téléphone doit être composé de 45 caractères au maximum.',
            'fax.max' => 'Le n° de fax doit être composé de 45 caractères au maximum.',
            'email.required' => 'Veuillez entrer une adresse e-mail pour le contact.',
            'email.max' => 'Maximum 45 caractères.',
            'company_id.exists' => 'Veuillez sélectionner une société parmi celles proposées.'
        ];
    }
}
