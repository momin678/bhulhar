<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_class_id')->nullable();
            $table->unsignedBigInteger('parent_profile_id');
            $table->unsignedBigInteger('section_id')->nullable();
            $table->integer('sis_number')->unique()->nullable();
            $table->integer('status')->default(1)->comment('1= current, 2= transferred');
            $table->string('transfer_note')->nullable();
            $table->date('transfer_date')->nullable();
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('family_name');
            $table->date('dob');
            $table->integer('standard');
            $table->string('photo');
            $table->string('student_number');
            $table->string('age');
            $table->string('transfer_certificate');
            $table->string('nationality');
            $table->string('place_of_birth');
            $table->string('emirates_id_num');
            $table->date('emirates_id_exp');
            $table->string('emirates_id_upload');
            $table->string('first_lang');
            $table->string('second_lang');           
            $table->string('passport_num');
            $table->string('passport_country');
            $table->string('visa_number');
            $table->string('visa_type');
            $table->string('visa_issue_place');
            $table->date('visa_exp');            
            $table->mediumText('local_address');
            $table->string('emirate_name');
            $table->string('telephone');
            $table->string('permanent_address');
            $table->string('permanent_telephone');
            $table->string('pre_school');
            $table->string('school_transport');
            $table->string('transport_area')->nullable();
            $table->string('scholership');
            $table->string('guardian');
            $table->string('cost_bearer');

            // $table->string('g_fname');
            // $table->string('g_mname');
            // $table->string('g_family_name');
            // $table->date('g_dob');
            // $table->string('g_nationality');
            // $table->string('g_emirates_id_num');
            // $table->date('g_emirates_id_exp');
            // $table->string('g_emirates_id_upload');
            // $table->string('g_first_lang');
            // $table->string('g_second_lang');
            // $table->string('g_mode_of_communication');            
            // $table->string('g_passport_num');
            // $table->string('g_passport_country');
            // $table->string('g_visa_number');
            // $table->string('g_visa_type');
            // $table->string('g_visa_issue_place');
            // $table->date('g_visa_exp');
            // $table->string('g_qualification');
            // $table->year('g_year_of_passing');
            // $table->string('g_institution');
            // $table->string('g_qualification_country');
            // $table->string('g_occupation');
            // $table->string('g_company_name');
            // $table->string('g_company_contact_details');
            // $table->integer('g_monthly_income');
            // $table->mediumText('g_local_address');
            // $table->string('g_emirate_name');
            // $table->string('g_telephone');
            // $table->string('g_pb_number')->nullable();
            // $table->string('g_permanent_address');
            // $table->string('g_permanent_telephone');
            
            $table->foreign('parent_profile_id')->references('id')->on('parent_profiles')->onDelete('cascade');
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
        Schema::dropIfExists('students');
    }
}
