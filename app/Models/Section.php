<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'academic_level_id', 'classroom_id'];

    /**
     * Get the academic level that this section belongs to.
     */
    public function academicLevel()
    {
        return $this->belongsTo(AcademicLevel::class);
    }

    /**
     * Get the classroom that this section belongs to.
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function teachers(){
        return $this->belongsToMany(Teacher::class,'teacher_section');
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function fees()
    {
        return $this->hasMany(Fees::class, 'section_id');
    }
}
