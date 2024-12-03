<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public function fatherParents()
    {
        return $this->hasMany(Parent::class, 'father_nationality_id');
    }

    public function motherParents()
    {
        return $this->hasMany(Parent::class, 'mother_nationality_id');
    }
}
