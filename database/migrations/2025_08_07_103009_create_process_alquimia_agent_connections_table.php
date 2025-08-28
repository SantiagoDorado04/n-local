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
        Schema::create('alquimia_agent_connections', function (Blueprint $table) {
            $table->id();
            $table->String('name');
            $table->text('description');
            $table->String('type');
            $table->boolean('status');
            $table->text('url');
            $table->text('apikey');
            $table->text('response_transformer');
            $table->text('request_boby');
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
        Schema::dropIfExists('alquimia_agent_connections');
    }
};
