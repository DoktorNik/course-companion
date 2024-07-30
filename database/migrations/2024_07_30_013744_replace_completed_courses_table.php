<?php

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('completed_courses_v2', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Course::class);
            $table->foreignIdFor(Student::class);
            $table->timestamps();
        });
        DB::statement(<<<SQL
            INSERT INTO completed_courses_v2 (id, course_id, student_id, created_at, updated_at)
            SELECT ECCC.id, ECCC.course_id, ECC.student_id, ECCC.created_at, ECCC.updated_at
            FROM completed_courses_courses AS ECCC
            INNER JOIN completed_courses AS ECC
                ON ECC.id = ECCC.completed_courses_id
        SQL
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(<<<SQL
            INSERT INTO completed_courses_courses (id, course_id, completed_courses_id, created_at, updated_at)
                SELECT E.id, E.course_id, ECC.id, E.created_at, E.updated_at
                FROM completed_courses_v2 as E
                INNER JOIN completed_courses AS ECC
                    ON ECC.student_id = E.student_id
            ON CONFLICT(id) DO NOTHING
        SQL
        );
        Schema::dropIfExists('completed_courses_v2');
    }
};
