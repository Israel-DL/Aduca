<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function quiz() { 
        return $this->belongsTo(CourseQuiz::class,'quiz_id'); 
    }
    public function options() { 
        return $this->hasMany(QuizOption::class,'question_id'); 
    }
}
