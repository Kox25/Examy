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
        Schema::create('employees_subjects', function (Blueprint $table) {
            // $table->id();
            // $table->bigIncrements('id'); 

            $table->bigInteger('employee_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();

            $table->primary(['employee_id', 'subject_id']);//set this two columns as primary

            // $table->string('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')->onDelete('cascade');

            // $table->string('subject_id');
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')->onDelete('cascade');

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
        Schema::dropIfExists('employees_subjects');
    }
};
