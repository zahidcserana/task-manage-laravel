<?php

namespace App\Http\Requests\Admission;

use App\Http\Requests\FormRequest;

class FilterRequest extends FormRequest
{
    public static function validationRules()
    {
        $rules = [
            'from_date_created' => [
                'date_format:Y-m-d'
            ],
            'to_date_created' => [
                'date_format:Y-m-d'
            ],
            'from_date_updated' => [
                'date_format:Y-m-d'
            ],
            'to_date_updated' => [
                'date_format:Y-m-d'
            ],
            'location_id' => [
                'exists:locations,id,deleted_at,NULL'
            ],
            'customer_id' => [
                'exists:customers,id,deleted_at,NULL'
            ],
        ];

        return $rules;
    }
}
