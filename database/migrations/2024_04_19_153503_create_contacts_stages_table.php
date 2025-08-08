<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('contacts_stages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('stage_id');
            $table->boolean('approved')->default(false); 

/*             $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('stage_id')->references('id')->on('e')->onDelete('cascade'); */
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts_stages');
    }
};
