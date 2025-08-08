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
        Schema::create('or_courses_comunications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('action');
            $table->text('message');

            $table->unsignedBigInteger('or_course_id');
            $table->unsignedBigInteger('or_channel_id');
            $table->unsignedBigInteger('user_created_at')->nullable();
            $table->unsignedBigInteger('user_updated_at')->nullable();
            $table->unsignedBigInteger('user_deleted_at')->nullable();

            $table->timestamps();

            $table->foreign('or_course_id')->references('id')->on('online_registrations_courses')->onDelete('cascade');
            $table->foreign('or_channel_id')->references('id')->on('online_registrations_channels')->onDelete('cascade');
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
        Schema::dropIfExists('or_courses_comunications');
    }
};
