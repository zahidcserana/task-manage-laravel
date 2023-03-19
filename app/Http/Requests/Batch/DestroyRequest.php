<?php

namespace App\Http\Requests\Batch;

use App\Http\Requests\FormRequest;

class DestroyRequest extends FormRequest
{
    public static function validationRules(): array
    {
        return [
            'id' => [
                'required',
                'exists:batches,id,deleted_at,NULL'
            ]
        ];
    }
}
