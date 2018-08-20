<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CompleteOrderRequest extends FormRequest
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
            'status' => 'required|in:incomplète',
            'business_id' => 'required|exists:businesses,id',
            'contact_id' => 'required',
            'company_id' => 'required_without:user_id|nullable|exists:companies,id',
            'user_id' => 'required_without:company_id|nullable|exists:users,id',
            'deliveries' => 'required|min:1',
            'deliveries.*.id' => 'exists:deliveries,id',
            'deliveries.*.contact_id' => 'required_without:deliveries.*.pickup|nullable|exists:contacts,id',
            'deliveries.*.pickup' => 'required_without:deliveries.*.contact_id|nullable',
            'deliveries.*.to_deliver_at' => 'required_if:deliveries.*.express,false',
            'deliveries.*.express' => 'required_if:deliveries.*.to_deliver_at,null|boolean',
            'deliveries.*.documents' => 'min:1',
            'deliveries.*.documents.*.article_id' => 'required'
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
            'status.required' => 'Le statut de la commande est requis.',
            'status.in' => 'Le statut de la commande est invalide.',

            'business_id.required' => 'La commande doit être associée à une affaire.',
            'business_id.exists' => "Aucune affaire portant cette référence n'existe.",

            'contact_id.required' => 'La commande doit être associée à un contact de facturation.',

            'company_id.required_without' => 'La commande doit être associée à une société ou à un utilisateur.',
            'company_id.exists' => "Aucune société portant cette référence n'existe.",

            'user_id.required_without' => 'La commande doit être associée à un utilisateur ou à une société.',
            'user_id.exists' => "L'utilisateur spécifié n'existe pas.",
            
            'deliveries.required' => 'Les livraisons relatives à la commande sont requises.',
            'deliveries.min' => 'La commande doit contenir au minimum une livraison.',
            
            'deliveries.*.id.exists' => "Aucune livraison portant cette référence n'existe.",

            'deliveries.*.contact_id.required_without' => "Aucun contact de livraison n'est spécifié pour la livraison.",
            'deliveries.*.contact_id.exists' => "Aucun contact de livraison portant cette référence n'existe.",

            'deliveries.*.to_deliver_at.required_if' => 'Vous devez sélectionner une date de livraison.',
        ];
    }
}
