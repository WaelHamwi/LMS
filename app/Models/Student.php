<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    protected $guard = 'student';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'gender',
        'blood',
        'nationality',
        'date_of_birth',
        'academic_level_id',
        'classroom_id',
        'section_id',
        'parent_id',
        'academic_year',
        'password'
    ];

    public function academicLevel()
    {
        return $this->belongsTo(AcademicLevel::class);
    }


    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function parent()
    {
        return $this->belongsTo(StudentParent::class, 'parent_id');
    }
    public function promotions()
    {
        return $this->hasMany(promoteStudent::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }
    public function todayAttendance()
    {
        return $this->hasOne(Attendance::class)->whereDate('attendance_date', now()->format('Y-m-d'));
    }
    public function feeInvoices()
    {
        return $this->hasMany(FeeInvoice::class);
    }
}
