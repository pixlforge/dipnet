<?php

namespace App\Http\Requests\Company;

class UpdateCompanyRequest extends StoreCompanyRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (auth()->user()->isAdmin()) {
            return array_merge(parent::rules(), [
                'business_id' => 'nullable|exists:businesses,id'
            ]);
        } else {
            return array_merge(parent::rules(), [
                'business_id' => 'required|exists:businesses,id'
            ]);
        }
    }

    public function messages()
    {
        return array_merge(parent::messages(), []);
    }
}
