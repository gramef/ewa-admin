<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('style_quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_text');
            $table->string('type')->default('single_choice'); // single_choice, multiple_choice
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('style_quiz_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('style_quiz_question_id');
            $table->string('option_text');
            $table->string('image_url')->nullable();
            $table->text('related_categories')->nullable(); // JSON or comma-separated IDs of categories
            $table->timestamps();

            $table->foreign('style_quiz_question_id')->references('id')->on('style_quiz_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('style_quiz_options');
        Schema::dropIfExists('style_quiz_questions');
    }
};
