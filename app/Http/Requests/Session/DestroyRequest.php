<?php

namespace App\Http\Requests\Session;

use App\Http\Requests\FormRequest;

class DestroyRequest extends FormRequest
{
    public static function validationRules(): array
    {
        return [
            'id' => [
                'required',
                'exists:sessions,id,deleted_at,NULL'
            ]
        ];
    }
}
