<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;

class SalaryComponent extends Model
{
    //slara process check
    public function check($employee)
    {
        $status = SalaryProcess::where('employee_id',$employee)->where('salary_component_id',$this->id)->where('status',1)->orderBy('id','DESC')->first();
        
        if($status) {

            // dd($status->value);
            return $status->amount;
        }
        return null;
    }
    protected $guarded = [];
}
