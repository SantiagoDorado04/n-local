<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->boolean('first');
            $table->unsignedBigInteger('previous_course')->nullable();
            $table->unsignedBigInteger('next_course')->nullable();
            $table->integer('duration');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('previous_course')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('next_course')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
