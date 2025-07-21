<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeEarlyLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_early_leaves', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->integer('employee_id');
            $table->time('from_time');
            $table->time('to_time');
            $table->string('days_leave');
            $table->text('leave_reason');
            $table->string('scan_copy')->nullable();
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
        Schema::dropIfExists('employee_early_leaves');
    }
}
