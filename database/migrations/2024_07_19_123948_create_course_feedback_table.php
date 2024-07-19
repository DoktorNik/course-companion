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
        Schema::create('course_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Course::class);
            $table->string('lecturer',128)->default('Unknown');
            $table->string('comment', 8096)->nullable();
            $table->decimal('ratingDifficulty', 1, 2)->nullable();
            $table->decimal('ratingWorkload', 1, 2)->nullable();
            $table->decimal('ratingClarity', 1,2)->nullable();
            $table->decimal('ratingRelevance', 1, 2)->nullable();
            $table->decimal('ratingInterest', 1, 2)->nullable();
            $table->decimal('ratingHelpfulness', 1, 2)->nullable();
            $table->decimal('ratingExperiential', 1, 2)->nullable();
            $table->decimal('ratingAffect', 1, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_feedback');
    }
};
