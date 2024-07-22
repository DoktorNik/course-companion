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
        Schema::table('courses', function (Blueprint $table) {
            $table->integer('ratingDifficulty')->unsigned()->default(0);
            $table->integer('ratingWorkload')->unsigned()->default(0);
            $table->integer('ratingClarity')->unsigned()->default(0);
            $table->integer('ratingRelevance')->unsigned()->default(0);
            $table->integer('ratingInterest')->unsigned()->default(0);
            $table->integer('ratingHelpfulness')->unsigned()->default(0);
            $table->integer('ratingExperiential')->unsigned()->default(0);
            $table->integer('ratingAffect')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('ratingDifficulty');
            $table->dropColumn('ratingWorkload');
            $table->dropColumn('ratingClarity');
            $table->dropColumn('ratingRelevance');
            $table->dropColumn('ratingInterest');
            $table->dropColumn('ratingHelpfulness');
            $table->dropColumn('ratingExperiential');
            $table->dropColumn('ratingAffect');
        });
    }
};
