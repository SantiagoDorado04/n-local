<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contacts_information_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('information_form_id');
            $table->datetime('date_completed');
            $table->timestamps();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts_information_forms');
    }
};
