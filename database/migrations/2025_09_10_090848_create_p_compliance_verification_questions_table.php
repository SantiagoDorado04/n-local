<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('p_compliance_verification_questions', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->integer('position')->default(0);

            $table->unsignedBigInteger('pc_verification_id');
            $table->foreign('pc_verification_id', 'pcv_questions_fk')
                ->references('id')
                ->on('process_compliance_verifications')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('p_compliance_verification_questions');
    }
};
