<?php

namespace App\JsonApi\V1\Admissions;

use Illuminate\Http\Request;
use LaravelJsonApi\Core\Resources\JsonApiResource;

class AdmissionResource extends JsonApiResource
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
            'discount' => $this->discount,
            'paid' => $this->paid,
            'institute' => $this->institute,
            'batch' => $this->batch,
            'student' => $this->student,
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
            $this->relation('batch'),
            $this->relation('student'),
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
