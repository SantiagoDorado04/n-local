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
        Schema::create('process_alquimia_agent_questions', function (Blueprint $table) {
            $table->id();
            $table->String('text');
            $table->text('prompt');
            $table->text('guide');
            $table->integer('position');

            $table->unsignedBigInteger('process_alquimia_agent_id')->nullable();

            $table->timestamps();

            $table->foreign('process_alquimia_agent_id', 'pa_agent_id_fk')
                ->references('id')
                ->on('process_alquimia_agents')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('process_alquimia_agent_questions');
    }
};
