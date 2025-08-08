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
        Schema::create('answers_form_4', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('commercial_action_id')->nullable();
            $table->integer('contact_id')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
            $table->text('question_16')->nullable();
            $table->text('question_17')->nullable();
            $table->text('question_18')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers_form_4');
    }
};
