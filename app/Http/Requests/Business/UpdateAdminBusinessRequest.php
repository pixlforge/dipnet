<?php

namespace App\Http\Requests\Business;

class UpdateAdminBusinessRequest extends StoreAdminBusinessRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return parent::authorize();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'folder_color' => 'required|in:red,orange,purple,blue'
        ]);
    }

    /**
     * @return array
     */
    public function messages()
    {
        return array_merge(parent::messages(), []);
    }
}
