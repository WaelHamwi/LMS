<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherSectionTable extends Migration
{
    public function up()
    {
        Schema::create('teacher_section', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teacher_section');
    }
}
