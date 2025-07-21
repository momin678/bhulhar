<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationeryPurcheseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stationery_purchese_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stationery_purchese_id');
            $table->bigInteger('stationery_id');
            $table->integer('quantity');
            $table->integer('stationery_price');
            $table->integer('total_price');
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
        Schema::dropIfExists('stationery_purchese_items');
    }
}
