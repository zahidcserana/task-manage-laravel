<?php

namespace App\JsonApi\V1\Admissions;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class AdmissionRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'fee' => ['nullable', 'numeric'],
            'remarks' => ['nullable', 'string'],
            'institute' => JsonApiRule::toOne(),
            'batch' => JsonApiRule::toOne(),
            'student' => JsonApiRule::toOne(),
        ];
    }
}
