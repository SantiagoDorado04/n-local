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
        Schema::create('process_alquimia_agent_answers', function (Blueprint $table) {
            $table->id();

            $table->text('answer');

            $table->unsignedInteger('contact_id');
            $table->unsignedBigInteger('process_alquimia_agent_id');
            $table->unsignedBigInteger('paa_question_id');

            $table->timestamps();

            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('process_alquimia_agent_id', 'pa_answers_agent_fk')
                ->references('id')->on('process_alquimia_agents')->onDelete('cascade');
            $table->foreign('paa_question_id', 'pa_answers_question_fk')
                ->references('id')->on('process_alquimia_agent_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('process_alquimia_agent_answers');
    }
};
