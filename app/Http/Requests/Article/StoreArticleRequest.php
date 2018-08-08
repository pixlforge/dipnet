<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return mixed
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
            'description' => 'nullable|string|min:3|max:45',
            'type' => 'required|string|in:impression,option',
            'greyscale' => 'required|boolean',
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
            'description.string' => 'La description doit être du texte.',
            'description.max' => 'Maximum 45 caractères.',

            'type.required' => 'Veuillez sélectionner un type.',
            'type.in' => 'Veuillez sélectionner un type parmi ceux proposés.',

            'greyscale.required' => 'Veuillez sélectionner une valeur.',
            'greyscale.boolean' => 'La valeur doit être vrai ou faux.'
        ];
    }
}
