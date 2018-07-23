<?php

namespace App\Http\Requests\Business;

class UpdateBusinessRequest extends StoreBusinessRequest
{
    public function authorize()
    {
        return parent::authorize();
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'folder_color' => 'required|in:red,orange,purple,blue'
        ]);
    }

    public function messages()
    {
        return array_merge(parent::messages(), []);
    }
}
