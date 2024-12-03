<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['parent_id', 'file_path'];

    public function parent()
    {
        return $this->belongsTo(Parent::class);
    }
}
