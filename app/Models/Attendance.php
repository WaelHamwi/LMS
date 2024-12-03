<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable=[
        'student_id',
        'academic_level_id',
        'classroom_id',
        'section_id',
        'teacher_id',
        'attendance_date',
        'attendance_status',
    ];
    protected $casts = [
        'attendance_date' => 'datetime',
    ];

    public function students()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }


    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function grade()
    {
        return $this->belongsTo(AcademicLevel::class, 'academic_level_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
