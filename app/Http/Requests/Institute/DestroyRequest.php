<?php

namespace App\Http\Requests\Institute;

use App\Http\Requests\FormRequest;

class DestroyRequest extends FormRequest
{
    public static function validationRules(): array
    {
        return [
            'id' => [
                'required',
                'exists:institutes,id,deleted_at,NULL'
            ]
        ];
    }
}
