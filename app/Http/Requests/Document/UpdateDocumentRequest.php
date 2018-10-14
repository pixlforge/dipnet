<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
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
            'width' => 'nullable|integer|min:1',
            'height' => 'nullable|integer|min:1',
            'nb_orig' => 'nullable|integer|min:1',
            'quantity' => 'nullable|integer|min:1',
            'finish' => 'nullable|string|in:plié,roulé,plat',
            'article_id' => 'nullable|exists:articles,id',
            'options.*.id' => 'nullable|exists:articles,id'
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
            'width.integer' => 'La largeur doit être un nombre entier.',
            'width.min' => 'Minimum 1',

            'height.integer' => 'La hauteur doit être un nombre entier.',
            'height.min' => 'Minimum 1',

            'nb_orig.integer' => "Le nombre d'originaux doit être un nombre entier.",
            'nb_orig.min' => 'Minimum 1',

            'nb_orig.integer' => 'La quantité doit être un nombre entier.',
            'nb_orig.min' => 'Minimum 1',

            'finish.string' => 'La finition doit être une chaîne de caractères.',
            'finish.in' => 'Veuillez sélectionner une finition parmi celles proposées.',

            'article_id.exists' => "L'article sélectionné est invalide.",

            'options.*.exists' => "L'option sélectionnée est invalide.",
        ];
    }
}
