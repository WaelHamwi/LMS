<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeInvoice extends Model
{
    use HasFactory;

    protected $table = 'fee_invoices';

    protected $fillable = [
        'title',
        'amount',
        'academic_level_id',
        'classroom_id',
        'section_id',
        'description',
        'year',
        'fee_type',
        'invoice_date',
        'student_id',
        'fee_id',
    ];

    public function academicLevel()
    {
        return $this->belongsTo(AcademicLevel::class, 'academic_level_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function fee()
    {
        return $this->belongsTo(Fees::class);
    }
}
