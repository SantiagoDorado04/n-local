<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('information_form_options', function (Blueprint $table) {
            $table->id();

            $table->text('text');
            $table->text('value');
            $table->integer('position');
            $table->unsignedBigInteger('information_form_question_id');
            
            $table->foreign('information_form_question_id')->references('id')->on('information_form_questions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('information_form_options');
    }
};
