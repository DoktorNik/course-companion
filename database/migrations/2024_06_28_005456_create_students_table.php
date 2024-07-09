<?php

use App\Models\Course;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->integer('number',false, true);
            $table->string('major');
            $table->string('concentration')->nullable();
            $table->decimal('creditsCompleted', 3,1)->default(0);
            $table->decimal('creditsCompletedMajor', 3,1)->default(0);
            $table->foreignId('student_courses_completed_id')->nullable();
            $table->string('eligibleRequiredCourses',2046)->nullable();
            $table->string('eligibleConcentrationCourses',2046)->nullable();
            $table->string('eligibleElectiveMajorCourses',2046)->nullable();
            $table->string('eligibleElectiveNonMajorCourses',2046)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
