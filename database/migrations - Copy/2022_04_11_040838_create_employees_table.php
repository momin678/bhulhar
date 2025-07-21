<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_of_employee_id')->nullable();
            $table->string('role')->nullable();
            $table->string('fname');
            $table->string('mname');
            $table->string('photo');
            $table->string('family_name');
            $table->date('dob');
            $table->string('nationality');
            $table->string('emirates_id_num');
            $table->date('emirates_id_exp');
            $table->string('emirates_id_upload');
            $table->string('passport_num');
            $table->string('passport_country');
            $table->string('visa_number');
            $table->string('visa_type');
            $table->string('visa_issue_place');
            $table->date('visa_exp');
            $table->string('qualification');
            $table->string('year_of_passing');
            $table->string('institution');
            $table->string('qualification_country');
            $table->string('local_address');
            $table->string('pb_number');
            $table->string('emirate_name');
            $table->string('permanent_address');
            $table->string('local_telephone');
            $table->string('permanent_telephone');
            $table->string('first_lang');
            $table->string('second_lang');
            $table->string('employee_role');
            $table->string('mode_of_communication');
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
        Schema::dropIfExists('employees');
    }
}
