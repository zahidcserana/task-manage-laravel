<?php

namespace App\Http\Requests\Guardian;

use App\Http\Requests\FormRequest;

class DestroyRequest extends FormRequest
{
    public static function validationRules(): array
    {
        return [
            'id' => [
                'required',
                'exists:guardians,id,deleted_at,NULL'
            ]
        ];
    }
}
