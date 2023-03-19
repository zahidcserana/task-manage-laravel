<?php

namespace App\Http\Requests\Session;

use App\Http\Requests\FormRequest;

class UpdateRequest extends FormRequest
{
    public static function validationRules(): array
    {
        $rules = [
            'id' => [
                'required',
                'exists:sessions,id,deleted_at,NULL'
            ],
            'title' => [
                'sometimes'
            ],
            'code' => [
                'required'
            ],
        ];

        return $rules;
    }
}
