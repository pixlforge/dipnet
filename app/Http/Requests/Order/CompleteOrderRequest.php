<?php

namespace App\Http\Requests\Order;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class CompleteOrderRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        // dd(request()->all());
        return [
            'status' => 'required|in:incomplète',
            'business_id' => 'required|exists:businesses,id',
            'contact_id' => 'required',
            'company_id' => 'required_without:user_id|nullable|exists:companies,id',
            'user_id' => 'required_without:company_id|nullable|exists:users,id',
            'deliveries' => 'required|min:1',
            'deliveries.*.id' => 'exists:deliveries,id',
            'deliveries.*.*.contact_id' => 'required|exists:contacts,id',
            'deliveries.*.*.to_deliver_at' => 'required',
            'deliveries.*.*.documents' => 'required|min:1',
            'deliveries.*.*.documents.*.id' => 'exists:documents,id',
            'deliveries.*.*.documents.*.article_id' => 'required',
        ];
    }

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

            'deliveries.*.contact_id.required' => "Aucun contact de livraison n'est spécifié pour la livraison.",

            'deliveries.*.*.to_deliver_at.required' => 'Une date de livraison est requise.',

            'deliveries.*.documents.required' => 'Les documents relatifs à la livraison sont requis.',
            'deliveries.*.documents.min' => 'La livraison doit contenir au minimum un document.',

            'deliveries.*.documents.*.id.exists' => "Aucun document portant cette référence n'existe.",

            'deliveries.*.*.documents.*.article_id.required' => "Une option d'impression est requise.",
        ];
    }
}
