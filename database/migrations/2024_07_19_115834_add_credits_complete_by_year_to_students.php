<?php

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
        Schema::table('students', function (Blueprint $table) {
            //
            $table->decimal('electivesCompletedFirstYear', 3,1)->default(0)->after('creditsCompletedMajor');
            $table->decimal('electivesCompletedSecondYear', 3,1)->default(0)->after('creditsCompletedFirstYear');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('electivesCompletedFirstYear');
            $table->dropColumn('electivesCompletedSecondYear');
        });
    }
};
