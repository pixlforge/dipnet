<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
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
            'order_id' => 'required|exists:orders,id',
            'contact_id' => 'required|exists:contacts,id',
            'internal_comment' => 'nullable|string'
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
            'order_id.required' => "Veuillez sélectionner une commande.",
            'order_id.exists' => "Veuillez sélectionner une commande parmi celles proposées.",
            'contact_id.required' => "Veuillez sélectionner un contact pour la livraison.",
            'contact_id.exists' => "Veuillez sélectionner un contact pour la livraison parmi ceux proposés."
        ];
    }
}
