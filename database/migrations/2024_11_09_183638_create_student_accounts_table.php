<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('student_accounts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->enum('type', ['fee_invoice', 'payment_received', 'fee_processing', 'fee_payment']);
            $table->foreignId('fee_invoice_id')->nullable()->constrained('fee_invoices')->cascadeOnDelete();
            $table->foreignId('receipt_id')->nullable()->constrained('receipt_students')->cascadeOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained('payment_fees')->cascadeOnDelete();
            $table->foreignId('processing_id')->nullable()->constrained('processing_fees')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->decimal('debit', 10, 2)->nullable();
            $table->decimal('credit', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_accounts');
    }
}
