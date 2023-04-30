<?php

namespace App\Http\Requests\Admission;

use App\Http\Requests\FormRequest;

class DestroyRequest extends FormRequest
{
    public static function validationRules(): array
    {
        return [
            'id' => [
                'required',
                'exists:admissions,id,deleted_at,NULL'
            ]
        ];
    }
}
