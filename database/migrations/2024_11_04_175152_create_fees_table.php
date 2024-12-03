<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('academic_level_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('classroom_id');
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2); 
            $table->string('fee_type');
            $table->year('year');
            $table->timestamps();

  
            $table->foreign('academic_level_id')->references('id')->on('academic_levels')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fees');
    }
};
