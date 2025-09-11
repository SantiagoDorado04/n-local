<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('process_compliance_verifications', function (Blueprint $table) {
            $table->id();
            $table->text('embed')->nullable(); // contenido embebido (ej: iframe, html, etc.)
            $table->json('required_steps')->nullable(); //Formulario, Retos - Entregables, Lienzo, Agente AlquimIA.
            $table->unsignedBigInteger('step_id');
            $table->foreign('step_id')->references('id')->on('steps')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('process_compliance_verifications');
    }
};
