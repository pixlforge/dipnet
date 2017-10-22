<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|unique:categories,id,:id|min:2|max:45'
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
            'name.unique' => 'Une catégorie portant ce nom existe déjà.',
            'name.min' => 'Minimum 2 caractères.',
            'name.max' => 'Maximum 45 caractères.'
        ];
    }
}
