<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'reference' => 'required|unique:orders,id|min:2|max:45',
            'status' => 'required|in:ok,nok|max:8',
            'business_id' => 'required|exists:businesses,id',
            'contact_id' => 'required|exists:contacts,id'
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
            'reference.min' => 'Minimum 2 caractères.',
            'reference.max' => 'Maximum 45 caractères.',
            'status.required' => 'Veuillez sélectionner un status.',
            'status.in' => 'Veuillez sélectionner un status parmi ceux proposés.',
            'status.max' => 'Maximum 8 caractères.',
            'business_id.required' => 'Veuillez sélectionner une affaire.',
            'business_id.exists' => 'Veuillez sélectionner une affaire parmi celles proposées.',
            'contact_id.required' => 'Veuillez sélectionner un contact.',
            'contact_id.exists' => 'Veuillez sélectionner un contact parmi ceux proposés.'
        ];
    }
}
