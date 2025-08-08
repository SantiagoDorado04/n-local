<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contacts_challenges', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->string('file')->nullable();
            $table->unsignedBigInteger('challenge_id');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('contacts_challenges');
    }
};
