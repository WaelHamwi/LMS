<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentParentsTable extends Migration
{
    public function up()
    {
        Schema::create('student_parents', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');

            // Father Details
            $table->string('father_name');
            $table->string('father_national_id');
            $table->string('father_passport_id');
            $table->string('father_phone');
            $table->string('father_job');
            $table->foreignId('father_nationality_id')->constrained('nationalities')->onDelete('cascade');
            $table->foreignId('father_blood_id')->constrained('bloods')->onDelete('cascade');
            $table->foreignId('father_religion_id')->constrained('religions')->onDelete('cascade');

            // Mother Details
            $table->string('mother_name');
            $table->string('mother_national_id');
            $table->string('mother_passport_id');
            $table->string('mother_phone');
            $table->string('mother_job');
            $table->foreignId('mother_nationality_id')->constrained('nationalities')->onDelete('cascade');
            $table->foreignId('mother_blood_id')->constrained('bloods')->onDelete('cascade');
            $table->foreignId('mother_religion_id')->constrained('religions')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_parents');
    }
}
