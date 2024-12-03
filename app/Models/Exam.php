<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{

    protected $fillable = [
        'name',
        'subject_id',
        'academic_level_id',
        'classroom_id',
        'section_id',
        'teacher_id',
        'done'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function academicLevel()
    {
        return $this->belongsTo(AcademicLevel::class, 'academic_level_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    
}
