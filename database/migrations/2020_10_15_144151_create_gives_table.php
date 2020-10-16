<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gives', function (Blueprint $table) {
            $table->id();
            $table->double('g_price');
            $table->dateTime('g_back')->nullable();
            $table->integer('g_amount');
            $table->boolean('g_state')->default(0);
            $table->unsignedBigInteger('g_student');
            $table->foreign('g_student')->references('id')->on('students');
            $table->unsignedBigInteger('g_book');
            $table->foreign('g_book')->references('id')->on('books');
            $table->unsignedBigInteger('g_admin');
            $table->foreign('g_admin')->references('id')->on('users');
            $table->dateTime('g_expire');

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
        Schema::dropIfExists('gives');
    }
}
