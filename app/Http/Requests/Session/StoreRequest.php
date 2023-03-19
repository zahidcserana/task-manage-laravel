<?php

namespace App\Http\Requests\Session;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    public static function validationRules(): array
    {
        $rules = [
            'title' => [
                'sometimes'
            ],
            'code' => [
                'required'
            ],
        ];

        return $rules;
    }
}
