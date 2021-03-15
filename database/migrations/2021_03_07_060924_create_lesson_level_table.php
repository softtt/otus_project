<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_level', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lesson_id');
            $table->bigInteger('level_id');
            $table->foreign('level_id')
                ->references('id')
                ->on('levels')->onDelete('cascade');
            $table->foreign('lesson_id')
                ->references('id')
                ->on('lessons')->onDelete('cascade');
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
        Schema::dropIfExists('lesson_level');
    }
}
