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
        Schema::create('online_registrations_courses', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->string('slug')->unique();
            $table->text('embebed_video')->nullable();
            $table->text('logo_file')->nullable();
            $table->unsignedBigInteger('or_category_id');
            // $table->unsignedBigInteger('self_assesment_id')->nullable();

            $table->foreign('or_category_id')->references('id')->on('online_registrations_categories')->onDelete('cascade');
            // $table->foreign('online_registration_id')->references('id')->on('online_registrations')->onDelete('cascade');
            //--
            $table->unsignedBigInteger('user_created_at')->nullable();
            $table->unsignedBigInteger('user_updated_at')->nullable();
            $table->unsignedBigInteger('user_deleted_at')->nullable();
            //--
            $table->timestamps();
            //--
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
        Schema::dropIfExists('online_registrations_courses');
    }
};
