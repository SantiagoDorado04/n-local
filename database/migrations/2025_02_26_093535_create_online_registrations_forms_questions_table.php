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
        Schema::create('online_registrations_forms_questions', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->text('type');
            $table->integer('position');
            $table->unsignedBigInteger('or_form_id');
            //--timestamps usuario
            $table->unsignedBigInteger('user_created_at')->nullable();
            $table->unsignedBigInteger('user_updated_at')->nullable();
            $table->unsignedBigInteger('user_deleted_at')->nullable();
            //--timestamps registro
            $table->timestamps();
            //-- llaves foraneas
            $table->foreign('or_form_id')->references('id')->on('online_registrations_forms')->onDelete('cascade');
            $table->foreign('user_created_at')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_updated_at')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_deleted_at')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('online_registrations_forms_questions');
    }
};
