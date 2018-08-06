<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required|mimes:jpeg,png,gif,psd,svg,pdf,doc,docx,xls,xlsx,ppt,pps,pot,pptx'
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Un fichier est requis.',
            'file.mimes' => "Vous n'êtes pas autorisé à télécharger ce type de fichier.",
        ];
    }
}
