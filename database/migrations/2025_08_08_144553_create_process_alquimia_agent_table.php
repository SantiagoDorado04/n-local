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
        Schema::create('process_alquimia_agents', function (Blueprint $table) {
            $table->id();
            $table->String('name');
            $table->text('description');
            $table->text('url_file')->nullable();
            $table->integer('points')->nullable();
            $table->integer('required_points')->nullable();
            $table->unsignedBigInteger('alquimia_connection_id')->nullable();
            $table->unsignedBigInteger('step_id');

            $table->timestamps();

            $table->foreign('alquimia_connection_id')->references('id')->on('alquimia_agent_connections')->onDelete('cascade');
            $table->foreign('step_id')->references('id')->on('steps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('process_alquimia_agents');
    }
};
