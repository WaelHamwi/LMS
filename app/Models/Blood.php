<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blood extends Model
{
    use HasFactory;

    protected $fillable = ['type'];
    public function fatherParents()
    {
        return $this->hasMany(StudentParent::class, 'father_blood_id');
    }

    public function motherParents()
    {
        return $this->hasMany(StudentParent::class, 'mother_blood_id');
    }
}
