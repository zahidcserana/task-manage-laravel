<?php

namespace App\Components;

use App\Http\Requests\Batch\{
    StoreRequest,
    UpdateRequest
};
use App\Models\{Batch};

class BatchComponent extends BaseComponent
{
    public function __construct()
    {
    }

    public function store(StoreRequest $request)
    {
        $input = $request->validated();

        $batch = Batch::create($input);

        return $batch;
    }

    public function update(UpdateRequest $request, Batch $batch = null)
    {
        $input = $request->validated();

        $batch->update($input);

        return $batch;
    }

    public function destroy(Batch $batch)
    {
        return $batch->delete();
    }
}
