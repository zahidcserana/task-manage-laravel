<?php

namespace App\Rules;

use App\Models\Admission;
use App\Models\Order;
use Illuminate\Contracts\Validation\Rule;

class UniqueAdmission implements Rule
{
    private $instituteId;
    private $batchId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($instituteId, $batchId)
    {
        $this->instituteId = $instituteId;
        $this->batchId = $batchId;
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

        $exists = Admission::where([
            'institute_id' => $this->instituteId,
            'batch_id' => $this->batchId,
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
        return trans(':attribute already exists for batch');
    }
}
