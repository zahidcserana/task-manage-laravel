<?php

namespace App\Http\Requests\Guardian;

use App\Http\Requests\FormRequest;

class UpdateRequest extends FormRequest
{
    public static function validationRules(): array
    {
        $rules = [
            'id' => [
                'required',
                'exists:guardians,id,deleted_at,NULL'
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
            'profession' => [
                'sometimes'
            ],
            'address' => [
                'sometimes'
            ],
        ];

        return $rules;
    }
}
