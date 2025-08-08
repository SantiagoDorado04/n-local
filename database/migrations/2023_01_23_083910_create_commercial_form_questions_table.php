<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_form_questions', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->text('question')->nullable();
            $table->char('type', 2)->nullable();
            $table->integer('commercial_form_id')->nullable();
            $table->char('visibility', 1)->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commercial_form_questions');
    }
};
