<?php

namespace Dipnet\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
            'reference' => 'required|unique:articles,id,:id|min:3|max:45',
            'description' => 'nullable|string|max:45',
            'type' => 'required|in:impression,option'
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
            'reference.required' => 'Veuillez entrer une référence.',
            'reference.unique' => 'Cette référence est déjà utilisée.',
            'reference.min' => 'Minimum 3 caractères.',
            'reference.max' => 'Maximum 45 caractères.',
            'description.string' => 'La description doit être du texte.',
            'description.max' => 'Maximum 45 caractères.',
            'type.required' => 'Veuillez sélectionner un type.',
            'type.in' => 'Veuillez sélectionner un type parmi ceux proposés.'
        ];
    }
}
