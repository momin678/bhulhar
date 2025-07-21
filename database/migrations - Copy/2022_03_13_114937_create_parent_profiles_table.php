<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('f_fname');
            $table->string('f_mname')->nullable();
            $table->string('f_family_name');
            $table->string('f_email_address');
            $table->date('f_dob');
            $table->string('f_nationality');
            $table->string('f_emirates_id_num');
            $table->date('f_emirates_id_exp');
            $table->string('f_emirates_id_upload');
            $table->string('f_first_lang');
            $table->string('f_second_lang');
            $table->string('f_mode_of_communication');            
            $table->string('f_passport_num');
            $table->string('f_passport_country');
            $table->string('f_visa_number');
            $table->string('f_visa_type');
            $table->string('f_visa_issue_place');
            $table->date('f_visa_exp');
            $table->string('f_qualification');
            $table->year('f_year_of_passing');
            $table->string('f_institution');
            $table->string('f_qualification_country');
            $table->string('f_occupation');
            $table->string('f_company_name');
            $table->string('f_company_contact_details');
            $table->integer('f_monthly_income');
            $table->mediumText('f_local_address');
            $table->string('f_emirate_name');
            $table->string('f_telephone');
            $table->string('f_pb_number')->nullable();
            $table->string('f_permanent_address');
            $table->string('f_permanent_telephone');
            $table->string('m_fname');
            $table->string('m_mname')->nullable();
            $table->string('m_family_name');
            $table->string('m_email_address');
            $table->date('m_dob');
            $table->string('m_nationality');
            $table->string('m_emirates_id_num');
            $table->date('m_emirates_id_exp');
            $table->string('m_emirates_id_upload');
            $table->string('m_first_lang');
            $table->string('m_second_lang');
            $table->string('m_mode_of_communication');            
            $table->string('m_passport_num');
            $table->string('m_passport_country');
            $table->string('m_visa_number');
            $table->string('m_visa_type');
            $table->string('m_visa_issue_place');
            $table->date('m_visa_exp');
            $table->string('m_qualification');
            $table->year('m_year_of_passing');
            $table->string('m_institution');
            $table->string('m_qualification_country');
            $table->string('m_occupation');
            $table->string('m_company_name');
            $table->string('m_company_contact_details');
            $table->integer('m_monthly_income');
            $table->mediumText('m_local_address');
            $table->string('m_emirate_name');
            $table->string('m_telephone');
            $table->string('m_pb_number')->nullable();
            $table->string('m_permanent_address');
            $table->string('m_permanent_telephone');            
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
        Schema::dropIfExists('parent_profiles');
    }
}
