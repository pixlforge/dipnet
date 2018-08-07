<?php

namespace App\Http\Requests\Ticker;

class UpdateTickerRequest extends StoreTickerRequest
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
