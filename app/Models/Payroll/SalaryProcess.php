<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class SalaryProcess extends Model
{
    public function items()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function salaryComponent()
    {
        return $this->belongsTo(SalaryComponent::class, 'salary_component_id');
    }

    public function components($id, $month, $year){
        return SalaryProcess::where('employee_id',$id)->where('month',$month)->where('year',$year)->get();
    }

    public function basicSalary($id,$month, $year){
        $earns = SalaryProcess::where('employee_id',$id)->where('salary_component_id', 1)->where('status', 1)->where('month',$month)->where('year',$year)->sum('amount');
        return $earns;
    }
    public function commission($id,$month, $year){
        $earns = SalaryProcess::where('employee_id',$id)->where('salary_component_id', 2)->where('status', 1)->where('month',$month)->where('year',$year)->sum('amount');
        return $earns;
    }
    public function totalSalary($id,$month, $year){
        $deduct = DeductionProcess::where('employee_id',$id)->where('status', 1)->sum('amount');
        $earns = SalaryProcess::where('employee_id',$id)->where('status', 1)->where('month',$month)->where('year',$year)->sum('amount');
        return $result =  $earns - $deduct;
    }

    public function deductComponents($id, $month, $year) {
        
        // $return = DeductionProcess::where('employee_id',$id)->where('month',$month)->where('year',$year)->get();
       
        return DeductionProcess::where('employee_id',$id)->where('month',$month)->where('year',$year)->get();
    }

    public function check($employee)
    {
        $status = DeductionEntry::where('employee_id',$employee)->where('due','!=', 0)->orderBy('id','DESC')->first();
        
        if($status) {

            // dd($status->value);
            return true;
        }
        return null;
    }

    public function deductProcessCheck($employee)
    {
        $status = DeductionProcess::where('employee_id',$employee)->where('status', 1)->orderBy('id','DESC')->first();
        
        if($status) {

            // dd($status->value);
            return true;
        }
        return null;
    }
    
    
    protected $guarded = [];
}
