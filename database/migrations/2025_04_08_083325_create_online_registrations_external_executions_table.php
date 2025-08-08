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
        Schema::create('online_registrations_external_executions', function (Blueprint $table) {
            $table->id();
            $table->string('method');
            $table->text('url')->nullable();
            $table->text('message');
            $table->string('status');
            $table->json('request');
            $table->string('type');

            $table->timestamps();
            $table->unsignedBigInteger('user_created_at')->nullable();
            $table->unsignedBigInteger('user_updated_at')->nullable();
            $table->unsignedBigInteger('user_deleted_at')->nullable();


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
        Schema::dropIfExists('online_registrations_external_executions');
    }
};
