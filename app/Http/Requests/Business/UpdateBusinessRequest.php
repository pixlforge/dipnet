<?php

namespace App\Http\Requests\Business;

use Illuminate\Validation\Rule;

class UpdateBusinessRequest extends StoreBusinessRequest
{
    public function authorize()
    {
        return parent::authorize();
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'reference' => [
                'required',
                Rule::unique('businesses')->ignore($this->id)
            ],
            'folder_color' => 'required|in:red,orange,purple,blue'
        ]);
    }

    public function messages()
    {
        return array_merge(parent::messages(), []);
    }
}
