<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\Company\StoreCompanyRequest;

class UpdateCompanyRequest extends StoreCompanyRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return array_merge(parent::messages(), []);
    }
}
