<?php

namespace App\Observers;

use App\Models\Student;
use App\Models\Admission;
use App\Models\Batch;

class StudentObserver
{
    /**
     * Handle the Student "created" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function created(Student $student): void
    {
        if (!empty($student->batch_id)) {
            $batch = Batch::find($student->batch_id);

            Admission::create([
                'student_id' => $student->id,
                'batch_id' => $student->batch_id,
                'fee' => $batch->fee,
            ]);
        }
    }

    /**
     * Handle the Student "updated" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function updated(Student $student)
    {
        if (!empty($student->batch_id)) {
            $batch = Batch::find($student->batch_id);

            Admission::firstOrCreate(
                ['student_id' => $student->id, 'batch_id' => $student->batch_id],
                ['fee' => $batch->fee],
            );
        }
    }

    /**
     * Handle the Student "deleted" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function deleted(Student $student)
    {
        //
    }

    /**
     * Handle the Student "restored" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function restored(Student $student)
    {
        //
    }

    /**
     * Handle the Student "force deleted" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function forceDeleted(Student $student)
    {
        //
    }
}
