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
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_id');
            $table->text('question');
            $table->enum('type', ['multiple_choice','true_false','short_answer'])->default('multiple_choice');
            $table->unsignedSmallInteger('points')->default(1);
            $table->timestamps();

            $table->foreign('quiz_id')->references('id')->on('course_quizzes')->onDelete('cascade');
            $table->index('quiz_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
