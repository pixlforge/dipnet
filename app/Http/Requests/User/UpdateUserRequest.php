<?php

namespace App\Http\Requests\User;

class UpdateUserRequest extends StoreUserRequest
{
    /**
     * @return bool
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
        return array_merge(parent::rules(), [
            'password' => 'nullable|string|min:6|confirmed',
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
