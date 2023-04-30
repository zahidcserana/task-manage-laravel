<?php

namespace App\Components;

use App\Http\Requests\Admission\{
    StoreRequest,
    UpdateRequest
};
use App\Models\{Admission};

class AdmissionComponent extends BaseComponent
{
    public function __construct()
    {
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        $admission = Admission::create($input);

        return $admission;
    }

    public function update(UpdateRequest $request, Admission $admission = null)
    {
        $input = $request->validated();

        $admission->update($input);

        return $admission;
    }

    public function destroy(Admission $admission)
    {
        return $admission->delete();
    }
}
