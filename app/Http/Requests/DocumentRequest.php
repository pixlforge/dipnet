<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
            'file_name' => 'required|min:3|max:255',
            'file_path' => 'required|min:3|max:255',
            'mime_type' => 'required|min:3|max:255',
            'quantity' => 'required|integer',
            'rolled_folded_flat' => 'required|in:roulé,plié,plat',
            'length' => 'required|integer',
            'width' => 'required|integer',
            'nb_orig' => 'required|integer',
            'free' => 'required|integer',
            'format_id' => 'required|exists:formats,id',
            'delivery_id' => 'nullable|exists:deliveries,id',
            'article_id' => 'required|exists:articles,id'
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
            'file_name.required' => 'Veuillez fournir un nom.',
            'file_name.min' => 'Minimum 3 caractères.',
            'file_name.max' => 'Maximum 255 caractères.',
            'file_path.required' => 'Veuillez fournir un chemin.',
            'file_path.min' => 'Minimum 3 caractères.',
            'file_path.max' => 'Maximum 255 caractères.',
            'mime_type.required' => 'Veuillez fournir un type.',
            'mime_type.min' => 'Minimum 3 caractères.',
            'mime_type.max' => 'Maximum 255 caractères.',
            'quantity.required' => 'Veuillez entrer une quantité.',
            'quantity.integer' => 'La quantité doit être un nombre entier.',
            'rolled_folded_flat.required' => 'Veuillez sélectionner une option.',
            'rolled_folded_flat.in' => 'Veuillez sélectionner une option parmi celles proposées.',
            'length.required' => 'Veuillez entrer une quantité.',
            'length.integer' => 'La quantité doit être un nombre entier.',
            'width.required' => 'Veuillez entrer une quantité.',
            'width.integer' => 'La quantité doit être un nombre entier.',
            'nb_orig.required' => 'Veuillez entrer une quantité.',
            'nb_orig.integer' => 'La quantité doit être un nombre entier.',
            'free.required' => 'Veuillez entrer une quantité.',
            'free.integer' => 'La quantité doit être un nombre entier.',
            'format_id.required' => 'Veuillez sélectionner un format.',
            'format_id.exists' => 'Veuillez sélectionner un format parmi ceux proposés.',
            'delivery_id.exists' => 'Veuillez sélectionner une livraison parmi celles proposées.',
            'article_id.required' => 'Veuillez sélectionner un articles.',
            'article_id.exists' => 'Veuillez sélectionner un articles parmi ceux proposés.'
        ];
    }
}
