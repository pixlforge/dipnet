<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactDetailsRequest extends FormRequest
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
            'address_line1' => 'required',
            'address_line2' => 'nullable',
            'zip' => 'required|min:4|max:16',
            'city' => 'required|min:2|max:45',
            'phone_number' => 'nullable|max:45',
            'fax' => 'nullable|max:45',
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
            'address_line1.required' => 'Veuillez entrer une adresse.',
            'zip.required' => 'Veuillez entrer un code postal.',
            'zip.min' => 'Le code postal doit être composé de 4 caractères au minimum.',
            'zip.max' => 'Le code postal doit être composé de 16 caractères au maximum.',
            'city.required' => 'Veuillez entrer une localité.',
            'city.min' => 'Minimum 2 caractères.',
            'city.max' => 'Maximum 45 caractères.',
            'phone_number.max' => 'Le n° de téléphone doit être composé de 45 caractères au maximum.',
            'fax.max' => 'Le n° de fax doit être composé de 45 caractères au maximum.'
        ];
    }
}
