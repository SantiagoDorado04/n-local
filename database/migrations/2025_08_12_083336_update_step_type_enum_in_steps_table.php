<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('steps', function (Blueprint $table) {
            DB::statement("ALTER TABLE `steps` MODIFY `step_type` ENUM('F', 'M', 'CD', 'FAA', 'LMS', 'LZ', 'VE', 'AL') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('steps', function (Blueprint $table) {
            DB::statement("ALTER TABLE `steps` MODIFY `step_type` ENUM('F', 'M', 'CD', 'FAA', 'LMS', 'LZ', 'VE') NOT NULL");
        });
    }
};
