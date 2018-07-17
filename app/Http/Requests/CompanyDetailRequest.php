<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyDetailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'nullable|min:2|max:45'
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'Minimum 2 caractères.',
            'name.max' => 'Maximum 45 caractères.'
        ];
    }
}
