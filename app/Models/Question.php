<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    
    protected $fillable = [
        'question_text',
        'answers',
        'correct_answer',
        'score',
        'exam_id',
    ];
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
