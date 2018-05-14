<?php

namespace App\Http\Requests\Business;

use Illuminate\Validation\Rule;

class UpdateBusinessRequest extends StoreBusinessRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return parent::authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return array_merge(parent::messages(), []);
    }
}
