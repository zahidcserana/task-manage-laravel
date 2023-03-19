<?php

namespace App\Components;

use App\Http\Requests\Session\{
    StoreRequest,
    UpdateRequest
};
use App\Models\{Session};

class SessionComponent extends BaseComponent
{
    public function __construct()
    {
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        $session = Session::create($input);

        return $session;
    }

    public function update(UpdateRequest $request, Session $session = null)
    {
        $input = $request->validated();

        $session->update($input);

        return $session;
    }

    public function destroy(Session $session)
    {
        return $session->delete();
    }
}
