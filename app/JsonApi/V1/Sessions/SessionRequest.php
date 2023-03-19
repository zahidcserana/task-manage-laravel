<?php

namespace App\JsonApi\V1\Sessions;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class SessionRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        $session = $this->model();
        $uniqueSlug = Rule::unique('sessions', 'title');

        if ($session) {
            $uniqueSlug->ignoreModel($session);
        }

        return [
            'title' => ['required', 'string', $uniqueSlug],
            'code' => ['required', 'string'],
            'institute' => JsonApiRule::toOne(),
        ];
    }
}
