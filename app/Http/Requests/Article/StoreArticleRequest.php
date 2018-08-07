<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    /**
     * @return mixed
     */
    public function authorize()
    {
        return true;
    }

    /**
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
