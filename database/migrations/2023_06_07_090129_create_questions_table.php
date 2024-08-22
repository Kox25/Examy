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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            $table->string('question');
            $table->integer('chapter_number');
            $table->integer('question_age')->default(0);
            $table->integer('question_mark');
            $table->enum('question_complexity', ['0', '1', '2'])->default('0'); //0: Easy, 1: Medium, 2: Difficult
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('cascade');

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
        Schema::dropIfExists('questions');
    }
};
