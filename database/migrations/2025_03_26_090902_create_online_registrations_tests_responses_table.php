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
        Schema::create('online_registrations_tests_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('contact_id');
            $table->foreignId('or_test_id')->constrained('online_registrations_tests_contents')->onDelete('cascade'); // Relación con lel contenido de la sesion
            $table->foreignId('or_item_id')->constrained('online_registrations_tests_items')->onDelete('cascade'); // Relación con lel contenido de la sesion
            $table->text('response');
            $table->boolean('is_correct')->default(0)->nullable(); // Indica si es correcta o no
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->unsignedBigInteger('user_created_at')->nullable();
            $table->unsignedBigInteger('user_updated_at')->nullable();
            $table->unsignedBigInteger('user_deleted_at')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('online_registrations_tests_responses');
    }
};
