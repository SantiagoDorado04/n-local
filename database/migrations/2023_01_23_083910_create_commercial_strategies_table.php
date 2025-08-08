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
        Schema::create('commercial_strategies', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->text('name')->nullable();
            $table->text('description')->nullable();
            $table->char('status', 1)->nullable();
            $table->integer('commercial_land_id')->nullable();
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
        Schema::dropIfExists('commercial_strategies');
    }
};
