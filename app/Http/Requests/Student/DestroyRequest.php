<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\FormRequest;

class DestroyRequest extends FormRequest
{
    public static function validationRules(): array
    {
        return [
            'id' => [
                'required',
                'exists:students,id,deleted_at,NULL'
            ]
        ];
    }
}
