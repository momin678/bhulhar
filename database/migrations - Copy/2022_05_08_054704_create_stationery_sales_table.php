<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationerySalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stationery_sales', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id');
            $table->integer('class_id');
            $table->integer('section_id');
            $table->date('sale_date');
            $table->integer('total_sale_amount');
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
        Schema::dropIfExists('stationery_sales');
    }
}
