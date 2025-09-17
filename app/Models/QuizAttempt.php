<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function quiz() {
        return $this->belongsTo(CourseQuiz::class, 'quiz_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answers() {
        return $this->hasMany(QuizAttemptAnswer::class, 'attempt_id');
    }
}
