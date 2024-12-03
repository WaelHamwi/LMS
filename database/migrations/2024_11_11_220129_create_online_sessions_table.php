<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('online_sessions', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_integrated');
            $table->foreignId('academic_level_id')->constrained('academic_levels')->onDelete('cascade');
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->string('created_by');
            $table->string('meeting_id');
            $table->string('topic');
            $table->dateTime('start_at');
            $table->integer('duration')->comment('minutes'); 
            $table->string('password');
            $table->text('start_url');
            $table->text('join_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('online_sessions');
    }
}
