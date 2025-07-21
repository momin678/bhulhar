<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempFeeCollectionSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_fee_collection_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('temp_number');
            $table->integer('head_id');
            $table->integer('class_id');
            $table->double('amount',12,2);
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
        Schema::dropIfExists('temp_fee_collection_schedules');
    }
}
