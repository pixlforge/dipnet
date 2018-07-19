<?php

namespace App\Http\Requests\User;

class UpdateUserRequest extends StoreUserRequest
{
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'password' => 'nullable|string|min:6|confirmed',
        ]);
    }

    public function messages()
    {
        return array_merge(parent::messages(), []);
    }
}
