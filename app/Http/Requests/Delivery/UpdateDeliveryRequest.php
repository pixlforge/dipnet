<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Validation\Rule;

class UpdateDeliveryRequest extends StoreDeliveryRequest
{
    public function authorize()
    {
        return parent::authorize();
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'reference' => [
                'required',
                Rule::unique('deliveries')->ignore($this->id)
            ],
            'note' => 'nullable|string|min:5|max:3000'
        ]);
    }

    public function messages()
    {
        return array_merge(parent::messages(), [
            'reference.required' => 'Veuillez entrer un numéro de référence.',
            'reference.unique' => 'La référence existe déjà.',
            'note.string' => 'La note doit être une chaîne de caractères.',
            'note.min' => 'Minimum 5 caractères.',
            'note.max' => 'Maximum 3000 caractères.'
        ]);
    }
}
