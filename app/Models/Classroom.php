<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected $table = 'classrooms';
    protected $fillable = ['academic_level_id', 'name', 'description'];

    public function academicLevel()
    {
        return $this->belongsTo(AcademicLevel::class);
    }
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function fees()
    {
        return $this->hasMany(Fees::class, 'classroom_id');
    }
}
