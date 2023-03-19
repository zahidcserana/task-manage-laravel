<?php

namespace App\Components;

use App\Http\Requests\User\{
    StoreRequest,
    UpdateRequest
};
use App\Models\{User};

class UserComponent extends BaseComponent
{
    public function __construct()
    {
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        $user = User::create($input);

        return $user;
    }

    public function update(UpdateRequest $request, User $user = null)
    {
        $input = $request->validated();

        $user->update($input);

        return $user;
    }

    public function destroy(User $user)
    {
        return $user->delete();
    }
}
