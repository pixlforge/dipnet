<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'body' => 'required|min:2|max:3000'
        ];
    }

    public function messages()
    {
        return [
            'body.required' => 'Un contenu est requis.',
            'body.min' => 'Minimum 2 caractères.',
            'body.max' => 'Maximum 3000 caractères.',
        ];
    }
}
