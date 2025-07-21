<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookLendingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_lendings', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('student_class_id');
            $table->integer('section_id');
            $table->integer('book_id');
            $table->date('essue_date');
            $table->date('receive_date')->nullable();
            $table->string('comment')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('book_lendings');
    }
}
