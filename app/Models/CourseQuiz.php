<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseQuiz extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function lecture() { 
        return $this->belongsTo(CourseLecture::class,'lecture_id'); 
    }
    public function questions() { 
        return $this->hasMany(QuizQuestion::class,'quiz_id'); 
    }
    public function attempts() { 
        return $this->hasMany(QuizAttempt::class,'quiz_id'); 
    }
}
