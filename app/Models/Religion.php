<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];
    public function fatherParents()
    {
        return $this->hasMany(Parent::class, 'father_religion_id');
    }

    public function motherParents()
    {
        return $this->hasMany(Parent::class, 'mother_religion_id');
    }
}
