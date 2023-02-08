<?php

namespace App\JsonApi\V1\Guardians;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class GuardianRequest extends ResourceRequest
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
            'profession' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'institute' => JsonApiRule::toOne(),
        ];
    }

}
