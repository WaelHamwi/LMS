<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicLevel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];
    protected $table = 'academic_levels';
    public $timestamps = true;
    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
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
        return $this->hasMany(Fees::class, 'academic_level_id');
    }
    
}
