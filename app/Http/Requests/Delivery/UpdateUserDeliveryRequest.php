<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserDeliveryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'note' => 'nullable|string|max:3000',
            'contact_id' => 'nullable|exists:contacts,id',
            'to_deliver_at' => 'nullable|date|after:today'
        ];
    }

    public function messages()
    {
        return [
            'note.string' => 'La note doit être une chaîne de caractères.',
            'note.max' => 'Maximum 3000 caractères.',

            'contact_id.exists' => 'Veuillez choisir un contact parmi ceux proposés.',

            'to_deliver_at.date' => 'Date invalide.',
            'to_deliver_at.after' => 'La date doit être fixé à demain au minimum.',
        ];
    }
}
