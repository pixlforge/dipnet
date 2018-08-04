<?php

namespace App\Http\Requests\Contact;

class UpdateAdminContactRequest extends StoreAdminContactRequest
{
    public function authorize()
    {
        return parent::authorize();
    }

    public function rules()
    {
        return array_merge(parent::rules(), []);
    }

    public function messages()
    {
        return array_merge(parent::messages(), []);
    }
}
