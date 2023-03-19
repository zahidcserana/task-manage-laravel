<?php

namespace App\Http\Requests\Batch;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public static function validationRules(): array
    {
        $instituteId = static::getInputField('institute_id');
        $gradeId = static::getInputField('grade_id');
        $id = static::getInputField('id');

        $rules = [
            'id' => [
                'required',
                'exists:batches,id,deleted_at,NULL'
            ],
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
                Rule::unique('batches', 'session_id')->ignore($id)->where(function ($query) use ($gradeId, $instituteId) {
                    $query->where('grade_id', $gradeId)->where('institute_id', $instituteId);
                })
            ],
            'fee' => [
                'nullable',
                'numeric'
            ],
        ];

        return $rules;
    }
}
