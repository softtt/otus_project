<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_task', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id');
            $table->bigInteger('task_id');
            $table->foreign('student_id')
                ->references('id')
                ->on('students')->onDelete('cascade');
            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')->onDelete('cascade');
            $table->boolean('is_finished')->default(false);
            $table->integer('tries')->default(0);
            $table->date('finish_until');
            $table->integer('mark');
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
        Schema::dropIfExists('student_task');
    }
}
