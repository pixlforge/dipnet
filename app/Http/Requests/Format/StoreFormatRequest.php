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
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:formats,id,:id|min:2|max:45',
            'height' => 'required',
            'width' => 'required',
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
            'name.unique' => 'Un format portant ce nom existe déjà.',
            'name.min' => 'Minimum 2 caractères.',
            'name.max' => 'Maximum 45 caractères.',
            'height.required' => 'Veuillez entrer une hauteur.',
            'width.required' => 'Veuillez entrer une largeur.'
        ];
    }
}
