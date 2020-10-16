<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('b_name');
            $table->integer('b_amount');
            $table->boolean('b_state');
            $table->unsignedBigInteger('b_department');
            $table->foreign('b_department')->references('id')->on('departments');
            $table->unsignedBigInteger('b_admin');
            $table->foreign('b_admin')->references('id')->on('users');
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
        Schema::dropIfExists('books');
    }
}
