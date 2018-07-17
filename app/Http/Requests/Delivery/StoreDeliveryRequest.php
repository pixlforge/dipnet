<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeliveryRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'order_id' => 'required|exists:orders,id'
        ];
    }

    public function messages()
    {
        return array_merge(parent::messages(), [
            'order_id.required' => 'Veuillez ajouter une commande.',
            'order_id.exists' => 'Vous devez sélectionnez une commande parmi celles proposées.'
        ]);
    }
}
