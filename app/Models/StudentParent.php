<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StudentParent extends Authenticatable
{
    
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'address',
        'father_name',
        'father_national_id',
        'father_passport_id',
        'father_phone',
        'father_job',
        'father_nationality',
        'father_blood',
        'father_religion_id',
        'mother_name',
        'mother_national_id',
        'mother_passport_id',
        'mother_phone',
        'mother_job',
        'mother_nationality',
        'mother_blood',
        'mother_religion_id'
    ];


    public function fatherReligion()
    {
        return $this->belongsTo(Religion::class, 'father_religion_id');
    }

    public function motherReligion()
    {
        return $this->belongsTo(Religion::class, 'mother_religion_id');
    }

    public function fatherNationality()
    {
        return $this->belongsTo(Nationality::class, 'father_nationality_id');
    }

    public function motherNationality()
    {
        return $this->belongsTo(Nationality::class, 'mother_nationality_id');
    }

    public function fatherBlood()
    {
        return $this->belongsTo(Blood::class, 'father_blood_id');
    }

    public function motherBlood()
    {
        return $this->belongsTo(Blood::class, 'mother_blood_id');
    }
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
