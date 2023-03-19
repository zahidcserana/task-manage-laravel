<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->decimal('fee')->nullable();
            $table->string('total_student')->nullable();

            $table->foreignId('institute_id')->cascadeOnDelete()->cascadeOnUpdate()->nullable()->constrained();
            $table->foreignId('grade_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate()->nullable();
            $table->foreignId('session_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batches');
    }
};
