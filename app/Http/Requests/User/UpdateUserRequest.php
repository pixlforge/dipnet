<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'username' => 'required|string|min:3|max:255',
            'role' => 'required|in:utilisateur,administrateur',
            'email' => 'required|email|unique:users,id,:id|max:255',
            'contact_id' => 'nullable|exists:contacts,id',
            'company_id' => 'nullable|exists:companies,id',
            'password' => 'nullable|string|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return array_merge(parent::messages(), []);
    }
}
