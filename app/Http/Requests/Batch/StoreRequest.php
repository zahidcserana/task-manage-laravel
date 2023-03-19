<?php

namespace App\Http\Requests\Batch;

use App\Http\Requests\FormRequest;
use App\Rules\UniqueBatch;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public static function validationRules(): array
    {
        $instituteId = static::getInputField('institute_id');
        $gradeId = static::getInputField('grade_id');

        $rules = [
            'grade_id' => [
                'required',
                'exists:grades,id'
            ],
            'institute_id' => [
                'required',
                'exists:institutes,id'
            ],
            'session_id' => [
                'required',
                'exists:sessions,id',
                new UniqueBatch($instituteId, $gradeId)
            ],
            'fee' => [
                'nullable',
                'numeric'
            ],
        ];

        return $rules;
    }
}
