<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineSession extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'online_sessions';

    // The attributes that are mass assignable.
    protected $fillable = [
        'is_integrated',
        'academic_level_id',
        'classroom_id',
        'section_id',
        'created_by',
        'meeting_id',
        'topic',
        'start_at',
        'duration',
        'password',
        'start_url',
        'join_url',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'start_at' => 'datetime',
    ];

    // Define relationships with other models, if any.
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
}
