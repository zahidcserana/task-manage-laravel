<?php

namespace App\JsonApi\V1\Batches;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class BatchRequest extends ResourceRequest
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
            'total_student' => ['nullable', 'string'],
            'institute' => JsonApiRule::toOne(),
            'grade' => JsonApiRule::toOne(),
            'session' => JsonApiRule::toOne(),
        ];
    }
}
