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
        Schema::create('process_advisor_scheduling', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('embed');
            $table->json('required_steps')->nullable(); //Formulario, Retos - Entregables, Lienzo, Agente AlquimIA.
            $table->unsignedBigInteger('step_id');
            $table->foreign('step_id')->references('id')->on('steps')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('process_advisor_scheduling');
    }
};
