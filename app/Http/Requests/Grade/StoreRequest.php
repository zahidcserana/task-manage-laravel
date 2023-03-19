<?php

namespace App\Http\Requests\Grade;

use App\Http\Requests\FormRequest;
use App\Models\Grade;
use App\Rules\UniqueForCustomer;
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
            'title' => [
                'required'
            ],
            'code' => [
                'required',
                new UniqueForCustomer(Grade::class, Auth::user()->institute_id)
            ],
        ];

        return $rules;
    }
}
