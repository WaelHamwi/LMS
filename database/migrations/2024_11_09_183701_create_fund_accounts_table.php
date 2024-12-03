<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('fund_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('receipt_id')->nullable()->constrained('receipt_students')->cascadeOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained('payment_fees')->cascadeOnDelete();
            $table->decimal('credit', 10, 2);
            $table->decimal('debit', 10, 2);
            $table->date('date');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fund_accounts');
    }
}
