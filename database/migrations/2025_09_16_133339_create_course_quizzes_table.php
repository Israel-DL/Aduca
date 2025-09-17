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
        Schema::create('course_quizzes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lecture_id');
            $table->string('title')->nullable();
            $table->tinyInteger('passing_score')->default(0);
            $table->unsignedSmallInteger('attempts_allowed')->nullable();
            $table->timestamps();

            $table->foreign('lecture_id')->references('id')->on('course_lectures')->onDelete('cascade');
            $table->index('lecture_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_quizzes');
    }
};
