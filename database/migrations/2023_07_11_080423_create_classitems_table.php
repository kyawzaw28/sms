<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classitems', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->time("start_time");
            $table->time("end_time");
            $table->string('day');
            $table->string('container_color');
            $table->integer('max_student');
            $table->enum('type', ['weekdays','weekend']);
            $table->string('price');
            $table->string('code');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('course_id');
            $table->timestamps();
            $table->foreign('room_id')->references('id')->on('rooms')
            ->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classitems');
    }
}
