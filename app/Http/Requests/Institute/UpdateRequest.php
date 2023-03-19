<?php

namespace App\Http\Requests\Institute;

use App\Http\Requests\FormRequest;

class UpdateRequest extends FormRequest
{
    public static function validationRules(): array
    {
        $rules = [
            'id' => [
                'required',
                'exists:institutes,id,deleted_at,NULL'
            ],
            'name' => [
                'required'
            ],
            'email' => [
                'sometimes'
            ],
            'mobile' => [
                'required'
            ],
            'established_at' => [
                'sometimes'
            ],
        ];

        return $rules;
    }
}
