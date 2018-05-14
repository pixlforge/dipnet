<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;

class RegisterContactRequest extends FormRequest
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
            'name' => 'required|min:3|max:45',
            'address_line1' => 'required|min:3|max:255',
            'address_line2' => 'nullable|min:3|max:255',
            'zip' => 'required|min:4|max:16',
            'city' => 'required|min:3|max:45',
            'phone_number' => 'nullable|max:45',
            'fax' => 'nullable|max:45'
        ];
    }

    /**
     * Validation error messages that apply to the request.
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
            'address_line1.min' => 'Minimum 3 caractères.',
            'address_line1.max' => 'Maximum 255 caractères.',
            'address_line2.min' => 'Minimum 3 caractères.',
            'address_line2.max' => 'Maximum 255 caractères.',
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
