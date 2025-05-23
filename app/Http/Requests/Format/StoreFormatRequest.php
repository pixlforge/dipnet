<?php

namespace App\Http\Requests\Format;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormatRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:45',
            'height' => 'required|numeric',
            'width' => 'required|numeric',
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
            'name.required' => 'Veuillez entrer un nom, entre 2 et 45 caractères.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.min' => 'Minimum 2 caractères.',
            'name.max' => 'Maximum 45 caractères.',

            'height.required' => 'Veuillez entrer une hauteur.',
            'height.numeric' => 'La hauteur doit être un nombre.',
            
            'width.required' => 'Veuillez entrer une largeur.',
            'width.numeric' => 'La largeur doit être un nombre.',
        ];
    }
}
