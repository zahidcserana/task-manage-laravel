<?php

namespace App\JsonApi\V1\Students;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class StudentRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['nullable', 'string'],
            'mobile' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
            'institute' => JsonApiRule::toOne(),
            'batch' => JsonApiRule::toOne(),
            'guardian' => JsonApiRule::toOne(),
        ];
    }
}
