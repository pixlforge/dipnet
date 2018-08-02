<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyDefaultBusinessRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'business_id' => 'required|exists:businesses,id'
        ];
    }

    public function messages()
    {
        return [
            'business_id.required' => 'Une affaire est requise.',
            'business_id.exists' => 'Affaire invalide'
        ];
    }
}
