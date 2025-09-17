<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttemptAnswer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function attempt() {
        return $this->belongsTo(QuizAttempt::class, 'attempt_id');
    }

    public function question() {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }

    public function option() {
        return $this->belongsTo(QuizOption::class, 'option_id');
    }
}
