<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * @return bool
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
            'body' => 'required|string|min:2|max:3000'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'body.required' => 'Un contenu est requis.',
            'body.string' => 'Le commentaire doit être une chaîne de caractères.',
            'body.min' => 'Minimum 2 caractères.',
            'body.max' => 'Maximum 3000 caractères.',
        ];
    }
}
