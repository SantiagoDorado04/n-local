<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('information_forms_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('information_form_id');
            $table->unsignedBigInteger('question_id');
            $table->text('answer');
            $table->timestamps();
            
/*             $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('information_form_id')->references('id')->on('information_forms')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('information_form_questions')->onDelete('cascade'); */
        });
    }


    public function down()
    {
        Schema::dropIfExists('information_forms_answers');
    }
};
