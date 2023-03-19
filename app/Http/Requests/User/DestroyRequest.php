<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;

class DestroyRequest extends FormRequest
{
    public static function validationRules(): array
    {
        return [
            'id' => [
                'required',
                'exists:users,id,deleted_at,NULL'
            ]
        ];
    }
}
