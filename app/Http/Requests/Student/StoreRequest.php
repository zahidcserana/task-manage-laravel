<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    public static function validationRules(): array
    {
        $rules = [
            'institute_id' => [
                'sometimes',
                'exists:institutes,id'
            ],
            'grade_id' => [
                'required',
                'exists:grades,id'
            ],
            'guardian_id' => [
                'sometimes',
                'exists:guardians,id'
            ],
            'email' => [
                'sometimes'
            ],
            'name' => [
                'required'
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
