<?php

use App\Models\CompletedCourses;
use App\Models\Course;
use App\Models\EligibleCoursesConcentration;
use App\Models\EligibleCoursesMajor;
use App\Models\Student;
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
        Schema::create('eligible_courses_concentration_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Course::class);
            $table->foreignIdFor(EligibleCoursesConcentration::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eligible_courses_concentration_courses');
    }
};
