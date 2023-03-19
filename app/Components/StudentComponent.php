<?php

namespace App\Components;

use App\Http\Requests\Student\{
    StoreRequest,
    UpdateRequest
};
use App\Models\{Student};

class StudentComponent extends BaseComponent
{
    public function __construct()
    {
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        $student = Student::create($input);

        return $student;
    }

    public function update(UpdateRequest $request, Student $student = null)
    {
        $input = $request->validated();

        $student->update($input);

        return $student;
    }

    public function destroy(Student $student)
    {
        return $student->delete();
    }
}
