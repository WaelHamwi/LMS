<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fees extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'academic_level_id',
        'section_id',
        'classroom_id',
        'description',
        'year',
        'fee_type',
        'amount'
    ];

    public function academicLevel()
    {
        return $this->belongsTo(AcademicLevel::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
