<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'reference' => [
                'required',
                'string',
                Rule::unique('articles')->ignore($this->id),
                'min:3',
                'max:45',
            ],
            'description' => 'nullable|string|min:3|max:45',
            'type' => 'required|string|in:impression,option',
            'greyscale' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'reference.required' => 'Veuillez entrer une référence.',
            'reference.unique' => 'Cette référence est déjà utilisée.',
            'reference.min' => 'Minimum 3 caractères.',
            'reference.max' => 'Maximum 45 caractères.',

            'description.string' => 'La description doit être du texte.',
            'description.max' => 'Maximum 45 caractères.',

            'type.required' => 'Veuillez sélectionner un type.',
            'type.in' => 'Veuillez sélectionner un type parmi ceux proposés.',

            'greyscale.required' => 'Veuillez sélectionner une valeur.',
            'greyscale.boolean' => 'La valeur doit être vrai ou faux.'
        ];
    }
}
