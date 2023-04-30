<?php

namespace App\JsonApi\V1\Batches;

use Illuminate\Http\Request;
use LaravelJsonApi\Core\Resources\JsonApiResource;

class BatchResource extends JsonApiResource
{

    /**
     * Get the resource's attributes.
     *
     * @param Request|null $request
     * @return iterable
     */
    public function attributes($request): iterable
    {
        return [
            'fee' => $this->fee,
            'total_student' => $this->total_student,
            'institute' => $this->institute,
            'session' => $this->session,
            'grade' => $this->grade,
        ];
    }

    /**
     * Get the resource's relationships.
     *
     * @param Request|null $request
     * @return iterable
     */
    public function relationships($request): iterable
    {
        return [
            $this->relation('institute'),
            $this->relation('grade'),
            $this->relation('session'),
        ];
    }

     /**
     * Get the resource's meta.
     *
     * @param \Illuminate\Http\Request|null $request
     * @return iterable
     */
    public function meta($request): iterable
    {
        return [
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
