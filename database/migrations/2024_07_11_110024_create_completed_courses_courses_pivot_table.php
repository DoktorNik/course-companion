<?php

use App\Models\CompletedCourses;
use App\Models\Course;
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
        Schema::create('completed_courses_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Course::class);
            $table->foreignIdFor(CompletedCourses::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completed_courses_courses');
    }
};
