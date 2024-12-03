<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('fee_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('amount', 10, 2);
            $table->foreignId('academic_level_id')->constrained('academic_levels')->onDelete('cascade');
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); 
            $table->foreignId('fee_id')->constrained('fees')->onDelete('cascade'); 
            $table->text('description')->nullable();
            $table->year('year');
            $table->string('fee_type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fee_invoices');
    }
};
