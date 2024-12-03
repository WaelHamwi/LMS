<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class promoteStudent extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'student_id',
        'current_academic_level_id',
        'current_classroom_id',
        'current_section_id',
        'new_academic_level_id',
        'new_classroom_id',
        'new_section_id',
        'old_academic_year_id', 
        'new_academic_year_id',
    ];

    // Define relationships if needed
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function currentAcademicLevel()
    {
        return $this->belongsTo(AcademicLevel::class, 'current_academic_level_id');
    }

    public function newAcademicLevel()
    {
        return $this->belongsTo(AcademicLevel::class, 'new_academic_level_id');
    }

    public function currentClassroom()
    {
        return $this->belongsTo(Classroom::class, 'current_classroom_id');
    }

    public function newClassroom()
    {
        return $this->belongsTo(Classroom::class, 'new_classroom_id');
    }

    public function currentSection()
    {
        return $this->belongsTo(Section::class, 'current_section_id');
    }

    public function newSection()
    {
        return $this->belongsTo(Section::class, 'new_section_id');
    }
}
