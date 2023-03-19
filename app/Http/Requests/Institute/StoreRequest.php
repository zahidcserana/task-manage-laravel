<?php

namespace App\Http\Requests\Institute;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    public static function validationRules(): array
    {
        $rules = [
            'email' => [
                'sometimes'
            ],
            'name' => [
                'required'
            ],
            'mobile' => [
                'required'
            ],
            'established_at' => [
                'sometimes'
            ],
        ];

        return $rules;
    }
}
