<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'nullable|min:3|max:45|unique:companies,name'
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'Minimum 3 caractères.',
            'name.max' => 'Maximum 45 caractères.',
            'name.unique' => 'Cette société existe déjà. Demandez une invitation à une personne possédant un compte valide associé à cette société.'
        ];
    }
}
