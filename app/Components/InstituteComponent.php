<?php

namespace App\Components;

use App\Http\Requests\Institute\{
    StoreRequest,
    UpdateRequest
};
use App\Models\{Institute};

class InstituteComponent extends BaseComponent
{
    public function __construct()
    {
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        $institute = Institute::create($input);

        return $institute;
    }

    public function update(UpdateRequest $request, Institute $institute = null)
    {
        $input = $request->validated();

        $institute->update($input);

        return $institute;
    }

    public function destroy(Institute $institute)
    {
        return $institute->delete();
    }
}
