<?php

namespace App\Http\Requests\Company;

class UpdateCompanyRequest extends StoreCompanyRequest
{
    /**
     * @return bool|mixed
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

    /**
     * @return array
     */
    public function messages()
    {
        return array_merge(parent::messages(), []);
    }
}
