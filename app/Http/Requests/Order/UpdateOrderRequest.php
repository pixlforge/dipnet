<?php

namespace App\Http\Requests\Order;

class UpdateOrderRequest extends StoreOrderRequest
{
    public function authorize()
    {
        return parent::authorize();
    }

    public function rules()
    {
        return array_merge(parent::rules(), []);
    }

    public function messages()
    {
        return array_merge(parent::messages(), []);
    }
}
