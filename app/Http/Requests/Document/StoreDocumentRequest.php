<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'file' => 'required|mimes:jpeg,png,gif,psd,svg,pdf,doc,docx,xls,xlsx,ppt,pps,pot,pptx'
        ];
    }
}
