<?php

namespace App\Components;

use App\Http\Requests\Grade\{
    StoreRequest,
    UpdateRequest
};
use App\Models\{Grade};

class GradeComponent extends BaseComponent
{
    public function __construct()
    {
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        $grade = Grade::create($input);

        return $grade;
    }

    public function update(UpdateRequest $request, Grade $grade = null)
    {
        $input = $request->validated();

        $grade->update($input);

        return $grade;
    }

    public function destroy(Grade $grade)
    {
        return $grade->delete();
    }
}
