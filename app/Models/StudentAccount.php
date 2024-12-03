<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'fee_invoice_id',
        'student_id',
        'receipt_id',
        'payment_id',
        'processing_id',
        'debit',
        'credit',
        'description',
        'type', 
    ];

    /**
     * Get the student associated with the student account.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the fee invoice associated with the student account.
     */
    public function feeInvoice()
    {
        return $this->belongsTo(FeeInvoice::class);
    }
}
