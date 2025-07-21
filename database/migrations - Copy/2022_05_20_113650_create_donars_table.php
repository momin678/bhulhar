<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->mediumtext('address');
            $table->string('phone');
            $table->string('email');
            $table->string('nationality');
            $table->string('emirates_id_num');
            $table->string('passport_num');
            $table->string('passport_country');
            $table->string('visa_number');
            $table->date('visa_exp');
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
        Schema::dropIfExists('donars');
    }
}
