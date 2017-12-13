<?php

namespace Dipnet\Http\Requests\Delivery;

class UpdateDeliveryRequest extends StoreDeliveryRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return parent::authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'reference' => 'required|unique:deliveries,reference',
            'note' => 'nullable|string|min:5|max:3000'
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return array_merge(parent::messages(), [
            'reference.required' => "Veuillez entrer un numéro de référence.",
            'reference.unique' => "La référence existe déjà.",
            'note.string' => "La note doit être une chaîne de caractères.",
            'note.min' => "Minimum 5 caractères.",
            'note.max' => "Maximum 3000 caractères."
        ]);
    }
}