<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    public function feeCheck($id)
    {
        $classFees=GradeWiseSalaryComponent::where('grade_id',$this->id)->where('salary_component_id',$id)->first();
        if($classFees) {

            return true;

        } else {

            return false;
        }
    }

    public function feeAmount($grade,$component)
    {
        $status=GradeWiseSalaryComponent::where('grade_id',$grade)->where('salary_component_id',$component)->orderBy('id','DESC')->first();
        // dd($fee);
        if($status)
        {
            return $status->value;
        }
        return null;
    }

//Extra component start
    public function extraCheck($component,$employee)
    {
        $classFees= ExtraSalaryComponent::where('employee_id',$employee)->where('salary_component_id',$component)->first();
        if($classFees) {

            return true;

        } else {

            return false;
        }
    }

    public function extraAmount($component,$employee)
    {
        $status = ExtraSalaryComponent::where('employee_id',$employee)->where('salary_component_id',$component)->orderBy('id','DESC')->first();
        // dd($fee);
        if($status)
        {
            return $status->value;
        }
        return null;
    }

    //Grade Wise salary component
    public function gradeWiseSalaryComponent()
    {
        $extra = $this->hasMany(GradeWiseSalaryComponent::class, 'grade_id');
        // dd($in->out == NULL);
        return $extra;
    }

    

    protected $guarded = [];
}
