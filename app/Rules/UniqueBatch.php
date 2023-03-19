<?php

namespace App\Rules;

use App\Models\Batch;
use App\Models\Order;
use Illuminate\Contracts\Validation\Rule;

class UniqueBatch implements Rule
{
    private $instituteId;
    private $gradeId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($instituteId, $gradeId)
    {
        $this->instituteId = $instituteId;
        $this->gradeId = $gradeId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $splitAttribute = explode('.', $attribute);
        $attribute = $splitAttribute[count($splitAttribute) - 1];

        $exists = Batch::where([
            'institute_id' => $this->instituteId,
            'grade_id' => $this->gradeId,
            $attribute => $value
        ])->exists();

        if ($exists) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans(':attribute already exists for institute');
    }
}
