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
        Schema::create('online_registrations_sessions_attendees', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('contact_id'); // Relación con la tabla de contactos
            $table->foreignId('session_id')->constrained('online_registrations_courses_sessions')->onDelete('cascade'); // Relación con las sesiones de curso
            $table->boolean('attended')->default(null)->nullable(); // Indica si asistió o no
            $table->unsignedBigInteger('user_created_at')->nullable(); // Usuario que creó
            $table->unsignedBigInteger('user_updated_at')->nullable(); // Usuario que actualizó
            $table->unsignedBigInteger('user_deleted_at')->nullable(); // Usuario que eliminó
            $table->foreign('user_created_at')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_updated_at')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_deleted_at')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('online_registrations_sessions_attendees');
    }
};
