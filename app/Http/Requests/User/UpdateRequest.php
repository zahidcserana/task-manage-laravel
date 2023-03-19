<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public static function validationRules(): array
    {
        $id = static::getInputField('id');
        $email = static::getInputField('email');

        $rules = [
            'id' => [
                'required',
                'exists:users,id,deleted_at,NULL'
            ],
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore($id)->where(function ($query) use ($email) {
                    $query->where('email', $email);
                })
            ],
            'name' => [
                'required'
            ],
        ];

        return $rules;
    }
}
