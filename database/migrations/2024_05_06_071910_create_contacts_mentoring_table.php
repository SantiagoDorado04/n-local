<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('contacts_mentoring', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('contact_id');
            $table->foreignId('step_id')->constrained();
            $table->foreignId('mentor_id')->constrained();
            $table->date('date');
            $table->time('start');
            $table->time('end');
            $table->timestamps();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts_mentoring');
    }
};
