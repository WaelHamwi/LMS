<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'receipt_id',
        'payment_id',
        'debit',
        'credit',
        'date',
        'description',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
