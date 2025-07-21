<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationerySaleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stationery_sale_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stationery_sale_id');
            $table->bigInteger('stationery_id');
            $table->integer('quantity');
            $table->integer('unite_sale_price');
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
        Schema::dropIfExists('stationery_sale_items');
    }
}
