<?php

use App\Models\StudentCoursesCompleted;
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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(StudentCoursesCompleted::class)->nullable();
            $table->string('code');
            $table->string('name');
            $table->string('duration');
            $table->string('isRequiredByMajor')->nullable();
            $table->string('concentration')->nullable();
            $table->integer('minimumGrade')->nullable();
            $table->integer('prereqCreditCount')->default(0);
            $table->integer('prereqCreditCountMajor')->default(0);
            $table->string('prereqs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
