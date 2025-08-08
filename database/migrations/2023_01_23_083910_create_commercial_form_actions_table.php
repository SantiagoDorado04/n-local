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
        Schema::create('commercial_form_actions', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->integer('commercial_action_id')->nullable();
            $table->integer('commercial_form_id')->nullable();
            $table->text('token')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('commercial_form_actions');
    }
};
