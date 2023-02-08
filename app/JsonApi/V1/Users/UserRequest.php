<?php

namespace App\JsonApi\V1\Users;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class UserRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        $user = $this->model();
        $uniqueEmail = Rule::unique('users', 'email');

        if ($user) {
            $uniqueEmail->ignoreModel($user);
        }

        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', $uniqueEmail],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
