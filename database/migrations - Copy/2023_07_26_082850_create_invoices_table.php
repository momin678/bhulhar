<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_no');
            $table->integer('student_id');
            $table->integer('class_id');
            $table->date('date');
            $table->double('total_due_amount', 12,2)->default(0.00);
            $table->double('paid_amount', 12,2)->default(0.00);
            $table->double('due_amount', 12,2)->default(0.00);
            $table->integer('is_paid')->default(0);
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
        Schema::dropIfExists('invoices');
    }
}
