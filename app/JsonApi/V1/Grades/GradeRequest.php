<?php

namespace App\JsonApi\V1\Grades;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class GradeRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'code' => ['nullable', 'string'],
            'title' => ['required', 'string'],
            'institute' => JsonApiRule::toOne(),
        ];
    }

}
