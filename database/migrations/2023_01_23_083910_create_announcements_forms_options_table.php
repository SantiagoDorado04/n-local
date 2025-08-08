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
        Schema::create('announcements_forms_options', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->integer('announcement_form_id')->nullable();
            $table->integer('commercial_question_id')->nullable();
            $table->integer('commercial_question_option_id')->nullable();
            $table->text('value')->nullable();
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
        Schema::dropIfExists('announcements_forms_options');
    }
};
