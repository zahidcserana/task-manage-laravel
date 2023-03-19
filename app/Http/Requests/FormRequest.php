<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;

class FormRequest extends IlluminateFormRequest
{
    /**
     * @var FormRequest
     */
    public static $formRequest;

    /**
     * @var bool
     */
    public static $isBatchRequest = false;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public static function make($record = [])
    {
        static::$isBatchRequest = false;
        $request = new static($record);
        $request->setContainer(app())->setRedirector(app()->make(Redirector::class));
        $request->validateResolved();

        return $request;
    }

    public static function validationRules()
    {
        return [];
    }

    public static function prefixedValidationRules($prefix, $isBatchRequest = false)
    {
        static::$isBatchRequest = $isBatchRequest;

        $rules = static::validationRules();

        foreach ($rules as $field => $fieldRules) {
            if (is_array($fieldRules)) {
                foreach ($fieldRules as &$fieldRule) {
                    if (is_string($fieldRule)) {
                        $fieldRule = preg_replace('/(required_.+):(.+)/', '$1:' . $prefix . '$2', $fieldRule);
                    }
                }
            }

            $rules[$prefix . $field] = $fieldRules;

            unset($rules[$field]);
        }

        return $rules;
    }

    public static function getInputField($name)
    {
        if (static::$isBatchRequest) {
            $data = static::$formRequest->all();
            return Arr::get($data, '0.' . $name);
        }
        return static::$formRequest->get($name);
    }

    public function rules()
    {
        static::$formRequest = $this;

        return static::validationRules();
    }
}
