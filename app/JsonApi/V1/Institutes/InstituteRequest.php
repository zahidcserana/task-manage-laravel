<?php

namespace App\JsonApi\V1\Institutes;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class InstituteRequest extends ResourceRequest
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
            'establishedAt' => ['nullable', JsonApiRule::dateTime()],
            'email' => ['required', 'string'],
            'mobile' => ['required', 'string'],
            'phone' => ['nullable', 'string'],
            'number' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
        ];
    }
}
