<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{


    protected $fillable = ['name', 'academic_level_id', 'classroom_id', 'teacher_id'];




    public function AcademicLevel()
    {
        return $this->belongsTo(AcademicLevel::class, 'academic_level_id');
    }


    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }


    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
