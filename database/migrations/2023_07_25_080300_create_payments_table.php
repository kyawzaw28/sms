<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('fees');
            $table->string('due_amount');
            $table->enum('payment_type', ['paid', 'unpaid']);
            $table->enum('payment_method', ['cash', 'card', 'bank transfer']);
            $table->unsignedBigInteger('classitem_id');
            $table->unsignedBigInteger('student_id');
            $table->timestamps();
            $table->foreign('classitem_id')->references('id')->on('classitems')
            ->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')
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
        Schema::dropIfExists('payments');
    }
}
