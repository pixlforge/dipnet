<?php

namespace App\Http\Requests\Format;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormatRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:45',
            'height' => 'required|numeric',
            'width' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Veuillez entrer un nom, entre 2 et 45 caractères.',
            'name.required' => 'Le nom doit être une chaîne de caractères.',
            'name.min' => 'Minimum 2 caractères.',
            'name.max' => 'Maximum 45 caractères.',

            'height.required' => 'Veuillez entrer une hauteur.',
            'height.numeric' => 'La hauteur doit être un nombre.',
            
            'width.required' => 'Veuillez entrer une largeur.',
            'width.numeric' => 'La largeur doit être un nombre.',
        ];
    }
}
