<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminDeliveryRequest extends FormRequest
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
            'note' => 'nullable|string|max:3000',
            'admin_note' => 'nullable|string|max:3000',
            'contact_id' => 'nullable|exists:contacts,id',
            'to_deliver_at' => 'nullable|date|after:today'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'note.string' => 'La note doit être une chaîne de caractères.',
            'note.max' => 'Maximum 3000 caractères.',

            'admin_note.string' => 'La note admin doit être une chaîne de caractères.',
            'admin_note.max' => 'Maximum 3000 caractères.',

            'contact_id.exists' => 'Veuillez choisir un contact parmi ceux proposés.',

            'to_deliver_at.date' => 'Date invalide.',
            'to_deliver_at.after' => 'La date doit être fixé à demain au minimum.',
        ];
    }
}
