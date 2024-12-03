<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promote_students', function (Blueprint $table) {
            $table->id();

            // Foreign key to students table
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');

            // Foreign keys for current year data with onDelete('cascade')
            $table->foreignId('current_academic_level_id')->constrained('academic_levels')->onDelete('cascade');
            $table->foreignId('current_section_id')->constrained('sections')->onDelete('cascade');
            $table->foreignId('current_classroom_id')->constrained('classrooms')->onDelete('cascade');

            // Foreign keys for promoted year data with onDelete('cascade')
            $table->foreignId('new_academic_level_id')->constrained('academic_levels')->onDelete('cascade');
            $table->foreignId('new_section_id')->constrained('sections')->onDelete('cascade');
            $table->foreignId('new_classroom_id')->constrained('classrooms')->onDelete('cascade');

            // Adding columns for old and new academic years 
            $table->integer('old_academic_year_id');
            $table->integer('new_academic_year_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promote_students');
    }
};
