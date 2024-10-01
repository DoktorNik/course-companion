<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('completed_courses_courses');
        Schema::dropIfExists('completed_courses');
        Schema::dropIfExists('eligible_courses_concentration_courses');
        Schema::dropIfExists('eligible_courses_concentrations');
        Schema::dropIfExists('eligible_courses_context_courses');
        Schema::dropIfExists('eligible_courses_contexts');
        Schema::dropIfExists('eligible_courses_elective_courses');
        Schema::dropIfExists('eligible_courses_electives');
        Schema::dropIfExists('eligible_courses_elective_major_courses');
        Schema::dropIfExists('eligible_courses_elective_majors');
        Schema::dropIfExists('eligible_courses_major_courses');
        Schema::dropIfExists('eligible_courses_majors');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
