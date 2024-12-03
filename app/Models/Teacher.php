<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teacher extends Authenticatable
{
    protected $guard = 'teacher'; 
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'gender_id',
        'specialization_id',
        'join_date',
        'address',
        'phone',
    ];
    protected $casts = [
        'join_date' => 'datetime',
    ];


    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
    public function sections()
    {
        return $this->belongsToMany(Section::class,'teacher_section');
    }
    
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
