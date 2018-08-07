<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class AvatarUploadRequest extends FormRequest
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
        return [
            'avatar' => 'required|image|max:2048'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'avatar.image' => 'Sélectionnez un format d\'image valide.'
        ];
    }
}
