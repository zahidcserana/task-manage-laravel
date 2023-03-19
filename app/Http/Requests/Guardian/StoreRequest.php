<?php

namespace App\Http\Requests\Guardian;

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
            'email' => [
                'sometimes'
            ],
            'name' => [
                'required'
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
