<?php

namespace Dipnet\Http\Requests\Company;

use Dipnet\Http\Requests\Company\StoreCompanyRequest;

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
        return array_merge(parent::rules(), [
            'business_id' => 'required|exists:businesses,id'
        ]);
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
