<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupFeeItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_fee_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_fee_id');
            $table->unsignedBigInteger('student_class_id');
            $table->year('education_year');
            $table->unsignedBigInteger('chart_of_account_id');
            $table->foreign('group_fee_id')->references('id')->on('group_fees')->onDelete('cascade');
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
        Schema::dropIfExists('group_fee_items');
    }
}
