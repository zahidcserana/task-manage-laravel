<?php

namespace App\Http\Requests\Admission;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public static function validationRules(): array
    {
        $instituteId = static::getInputField('institute_id');
        $batchId = static::getInputField('batch_id');
        $id = static::getInputField('id');

        $rules = [
            'id' => [
                'required',
                'exists:admissions,id,deleted_at,NULL'
            ],
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
                Rule::unique('admissions', 'student_id')->ignore($id)->where(function ($query) use ($batchId, $instituteId) {
                    $query->where('batch_id', $batchId)->where('institute_id', $instituteId);
                })
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
