<?php

namespace App\Http\Requests\Admission;

use App\Http\Requests\FormRequest;
use App\Rules\UniqueAdmission;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public static function validationRules(): array
    {
        $instituteId = static::getInputField('institute_id');
        $batchId = static::getInputField('batch_id');

        $rules = [
            'batch_id' => [
                'required',
                'exists:batches,id'
            ],
            'institute_id' => [
                'required',
                'exists:institutes,id'
            ],
            'student_id' => [
                'required',
                'exists:students,id',
                new UniqueAdmission($instituteId, $batchId)
            ],
            'fee' => [
                'nullable',
                'numeric'
            ],
            'discount' => [
                'nullable',
                'numeric'
            ],
            'paid' => [
                'nullable',
                'numeric'
            ],
            'remarks' => [
                'sometimes',
            ],
        ];

        return $rules;
    }
}
