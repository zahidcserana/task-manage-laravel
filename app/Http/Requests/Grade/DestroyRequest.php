<?php

namespace App\Http\Requests\Grade;

use App\Http\Requests\FormRequest;

class DestroyRequest extends FormRequest
{
    public static function validationRules(): array
    {
        return [
            'id' => [
                'required',
                'exists:grades,id,deleted_at,NULL'
            ]
        ];
    }
}
