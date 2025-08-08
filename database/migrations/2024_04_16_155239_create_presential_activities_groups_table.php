<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('presential_activities_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->time('hour');
            $table->integer('quota');
            $table->unsignedBigInteger('presential_activity_id');
            $table->foreign('presential_activity_id')->references('id')->on('presential_activities')->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('presential_activities_groups');
    }
};
