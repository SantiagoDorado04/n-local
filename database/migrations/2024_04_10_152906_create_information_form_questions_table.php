<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('information_form_questions', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->enum('type', ['AC',' AL','OS', 'OM', 'AD']);
            $table->integer('position');
            $table->unsignedBigInteger('information_form_id');
            $table->foreign('information_form_id')->references('id')->on('information_forms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('information_form_questions');
    }
};
