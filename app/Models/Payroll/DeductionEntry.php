<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;

class DeductionEntry extends Model
{
    public function items()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    
    public function check($employee)
    {
        $status = DeductionProcess::where('employee_id',$employee)->where('deduction_component_id',$this->id)->where('status',1)->orderBy('id','DESC')->first();
        
        if($status) {

            // dd($status->value);
            return $status->amount;
        }
        return null;
    }

    protected $guarded = [];
}
