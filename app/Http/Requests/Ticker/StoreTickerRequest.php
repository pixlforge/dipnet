<?php

namespace App\Http\Requests\Ticker;

use Illuminate\Foundation\Http\FormRequest;

class StoreTickerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'body' => 'required|string|min:5|max:255',
            'active' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'body.required' => 'Le champ contenu ne doit pas être vide.',
            'body.string' => 'Le contenu doit être une chaîne de caractères.',
            'body.min' => 'Le contenu doit comporter au minimum 5 caractères.',
            'body.max' => 'Le contenu doit composer au maximum 255 caractères.',

            'active.required' => 'Le champ actif ne peut pas être indéfini.',
            'active.boolean' => 'Le champ actif doit avoir une valeur booléenne.'
        ];
    }
}
