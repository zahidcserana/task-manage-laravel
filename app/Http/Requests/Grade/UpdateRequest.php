<?php

namespace App\Http\Requests\Grade;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public static function validationRules(): array
    {
        $id = static::getInputField('id');

        $rules = [
            'id' => [
                'required',
                'exists:grades,id,deleted_at,NULL'
            ],
            'title' => [
                'required'
            ],
            'code' => [
                'required',
                Rule::unique('grades', 'code')->ignore($id)->where(function ($query) {
                    $query->where('institute_id', Auth::user()->institute_id);
                })
            ],
        ];

        return $rules;
    }
}
