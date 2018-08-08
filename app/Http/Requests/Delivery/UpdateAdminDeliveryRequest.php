<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminDeliveryRequest extends FormRequest
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
            'note' => 'nullable|string|max:3000',
            'admin_note' => 'nullable|string|max:3000',
            'contact_id' => 'nullable|exists:contacts,id',
            'to_deliver_at' => 'nullable|date|after:today'
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
