<?php

namespace App\Components;

use App\Http\Requests\Guardian\{
    StoreRequest,
    UpdateRequest
};
use App\Models\{Guardian};

class GuardianComponent extends BaseComponent
{
    public function __construct()
    {
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        $guardian = Guardian::create($input);

        return $guardian;
    }

    public function update(UpdateRequest $request, Guardian $guardian = null)
    {
        $input = $request->validated();

        $guardian->update($input);

        return $guardian;
    }

    public function destroy(Guardian $guardian)
    {
        return $guardian->delete();
    }
}
