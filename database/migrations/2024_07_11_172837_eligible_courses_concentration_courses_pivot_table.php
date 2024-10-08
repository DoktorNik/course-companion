<?php

use App\Models\Course;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('eligible_courses_concentration_courses')) {
            Schema::create('eligible_courses_concentration_courses', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(Course::class);
                $table->foreignId('eligible_courses_concentration_id')
                    ->constrained('eligible_courses_concentrations');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eligible_courses_concentration_courses');
    }
};
