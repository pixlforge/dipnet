<?php

namespace App\Http\Requests\Business;

class UpdateUserBusinessRequest extends StoreUserBusinessRequest
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
        return array_merge(parent::rules(), []);
    }

    /**
     * @return array
     */
    public function messages()
    {
        return array_merge(parent::messages(), []);
    }
}
