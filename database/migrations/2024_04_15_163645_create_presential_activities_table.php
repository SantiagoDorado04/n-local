<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('presential_activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->time('hour');
            $table->string('location');
            $table->string('facilitator');
            $table->integer('duration');
            $table->string('registration_link')->nullable();
            $table->string('event_type');
            $table->string('virtual_link')->nullable();
            $table->unsignedBigInteger('step_id');
            $table->foreign('step_id')->references('id')->on('steps')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('presential_activities');
    }
};
