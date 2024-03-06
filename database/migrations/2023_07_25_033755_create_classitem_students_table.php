<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassitemStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classitem_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classitem_id');
            $table->unsignedBigInteger('student_id');
            $table->timestamps();
            $table->foreign('classitem_id')->references('id')->on('classitems')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classitem_students');
    }
}
