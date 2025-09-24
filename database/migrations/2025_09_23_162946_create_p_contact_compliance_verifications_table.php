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
        Schema::create('p_contact_compliance_verifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->onDelete('cascade');
            $table->unsignedBigInteger('pc_verification_id');
            $table->foreign('pc_verification_id')
                ->references('id')
                ->on('process_compliance_verifications')
                ->onDelete('cascade');
            $table->datetime('date_completed');
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
        Schema::dropIfExists('p_contact_compliance_verifications');
    }
};
