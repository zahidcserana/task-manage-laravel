<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\FormRequest;

class UpdateRequest extends FormRequest
{
    public static function validationRules(): array
    {
        $rules = [
            'id' => [
                'required',
                'exists:students,id,deleted_at,NULL'
            ],
            'batch_id' => [
                'sometimes',
                'exists:batches,id'
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
            'remarks' => [
                'sometimes'
            ],
            'address' => [
                'sometimes'
            ],
        ];

        return $rules;
    }
}
