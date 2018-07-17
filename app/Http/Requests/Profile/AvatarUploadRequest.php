<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class AvatarUploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'avatar' => 'required|image|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'avatar.image' => 'Sélectionnez un format d\'image valide.'
        ];
    }
}
