<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1) process_tests
        Schema::create('process_tests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();

            $table->unsignedBigInteger('step_id');
            $table->foreign('step_id')
                ->references('id')
                ->on('steps')
                ->onDelete('cascade');

            $table->timestamps();
        });

        // 2) process_test_categories
        Schema::create('process_test_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();

            $table->unsignedBigInteger('process_test_id');
            $table->foreign('process_test_id')
                ->references('id')
                ->on('process_tests')
                ->onDelete('cascade');
            $table->timestamps();
        });

        // 3) process_test_subcategories
        Schema::create('process_test_subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();

            $table->unsignedBigInteger('p_test_category_id');
            $table->foreign('p_test_category_id')
                ->references('id')
                ->on('process_test_categories')
                ->onDelete('cascade');
            $table->timestamps();
        });

        // 4) process_test_questions
        Schema::create('process_test_questions', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->integer('position')->nullable();

            $table->unsignedBigInteger('process_test_id');
            $table->foreign('process_test_id')
                ->references('id')
                ->on('process_tests')
                ->onDelete('cascade');

            $table->unsignedBigInteger('p_test_subcategory_id')->nullable();
            $table->foreign('p_test_subcategory_id')
                ->references('id')
                ->on('process_test_subcategories')
                ->onDelete('cascade');

            $table->timestamps();
        });

        // 5) process_test_options
        Schema::create('process_test_options', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('value')->nullable();
            $table->integer('position')->nullable();
            $table->integer('points')->default(0);

            $table->unsignedBigInteger('process_test_id');
            $table->foreign('process_test_id')
                ->references('id')
                ->on('process_tests')
                ->onDelete('cascade');

            $table->unsignedBigInteger('p_test_question_id');
            $table->foreign('p_test_question_id')
                ->references('id')
                ->on('process_test_questions')
                ->onDelete('cascade');

            $table->timestamps();
        });

        // 6) process_test_answers
        Schema::create('process_test_answers', function (Blueprint $table) {
            $table->id();
            $table->text('answer')->nullable();

            $table->unsignedInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->onDelete('cascade');

            $table->integer('points')->default(0);

            $table->unsignedBigInteger('process_test_id');
            $table->foreign('process_test_id')
                ->references('id')
                ->on('process_tests')
                ->onDelete('cascade');

            $table->unsignedBigInteger('p_test_subcategory_id')->nullable();
            $table->foreign('p_test_subcategory_id')
                ->references('id')
                ->on('process_test_subcategories')
                ->onDelete('cascade');

            $table->unsignedBigInteger('p_test_question_id');
            $table->foreign('p_test_question_id')
                ->references('id')
                ->on('process_test_questions')
                ->onDelete('cascade');

            $table->timestamps();
        });

        // 7) process_contacts_tests
        Schema::create('process_contacts_tests', function (Blueprint $table) {
            $table->id();
            $table->date('date_completed')->nullable();
            $table->boolean('approved')->default(false);

            $table->unsignedInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->onDelete('cascade');

            $table->unsignedBigInteger('process_test_id');
            $table->foreign('process_test_id')
                ->references('id')
                ->on('process_tests')
                ->onDelete('cascade');

            $table->timestamps();
        });

        // 8) process_test_appreciations
        Schema::create('process_test_appreciations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('appreciation');
            $table->integer('start_points');
            $table->integer('end_points');

            $table->unsignedBigInteger('process_test_id');
            $table->foreign('process_test_id')
                ->references('id')
                ->on('process_tests')
                ->onDelete('cascade');
            $table->timestamps();
        });

        // 9) p_test_category_appreciations
        Schema::create('p_test_category_appreciations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('appreciation');
            $table->integer('start_points');
            $table->integer('end_points');

            $table->unsignedBigInteger('p_test_category_id');
            $table->foreign('p_test_category_id')
                ->references('id')
                ->on('process_test_categories')
                ->onDelete('cascade');
            $table->timestamps();
        });

        // 10) p_test_subcategory_appreciations
        Schema::create('p_test_subcategory_appreciations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('appreciation');
            $table->integer('start_points');
            $table->integer('end_points');

            $table->unsignedBigInteger('p_test_subcategory_id');
            $table->foreign('p_test_subcategory_id')
                ->references('id')
                ->on('process_test_subcategories')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('p_test_subcategory_appreciations');
        Schema::dropIfExists('p_test_category_appreciations');
        Schema::dropIfExists('process_test_appreciations');
        Schema::dropIfExists('process_contacts_tests');
        Schema::dropIfExists('process_test_answers');
        Schema::dropIfExists('process_test_options');
        Schema::dropIfExists('process_test_questions');
        Schema::dropIfExists('process_test_subcategories');
        Schema::dropIfExists('process_test_categories');
        Schema::dropIfExists('process_tests');
    }
};
