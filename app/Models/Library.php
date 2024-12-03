<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $table="library";
   /* protected $fillable = [
        'title',
        'academic_level_id',
        'classroom_id',
        'section_id',
        'file_name',
        'teacher_id',
    ];*/
    public function AcademicLevel()
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

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }


}
