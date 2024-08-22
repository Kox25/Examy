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
        Schema::create('exams_questions', function (Blueprint $table) {
            // $table->id();

            $table->bigInteger('exam_id')->unsigned();
            $table->bigInteger('question_id')->unsigned();

            $table->primary(['exam_id', 'question_id']);//set this two columns as primary

            // $table->string('exam_id');
            $table->foreign('exam_id')
                ->references('id')
                ->on('exams')->onDelete('cascade');

            // $table->string('question_id');
            $table->foreign('question_id')
                ->references('id')
                ->on('questions')->onDelete('cascade');

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
        Schema::dropIfExists('exams_questions');
    }
};
