<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('p_compliance_verification_answers', function (Blueprint $table) {
            $table->id();
            $table->text('answer')->nullable();

            // contact_id igual que en tus otras tablas
            $table->unsignedInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->onDelete('cascade');

            // relación con process_compliance_verifications
            $table->unsignedBigInteger('pc_verification_id');
            $table->foreign('pc_verification_id', 'pcv_answers_verification_fk')
                ->references('id')
                ->on('process_compliance_verifications')
                ->onDelete('cascade');

            // relación con preguntas
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id', 'pcv_answers_question_fk')
                ->references('id')
                ->on('p_compliance_verification_questions')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('p_compliance_verification_answers');
    }
};
