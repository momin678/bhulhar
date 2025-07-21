<?php

namespace App;

use App\Models\Payroll\ExtraSalaryComponentHistory;
use App\Models\Payroll\GradeWiseSalaryComponentHistory;
use Illuminate\Database\Eloquent\Model;

class JobProjectTask extends Model
{
    protected $guarded=[];

    public function project(){
        return $this->belongsTo(JobProject::class);
    }
    public function vat(){
        return $this->belongsTo(VatRate::class);
    }

    public function expenses(){
        return $this->hasMany(PurchaseExpenseItem::class,'task_id');
    }
    public function task_expenses(){
        return $this->hasMany(BillDistribute::class,'task_id');
    }
    public function project_task_base_expense($project_id, $task_id){
        // employee attendance
        $employee_attendances = EmployeeAttendance::with('employee')->where('project_id', $project_id)->where('project_task_id', $task_id)->get();
        // return count($employee_attendances);
        $total_amount = 0;
        $basic_salary = 0;
        $over_time_amount = 0;
        foreach($employee_attendances as $key => $one_day){
            $per_day_salary = 0;
            $per_day_extra_salary = 0;
            $days_counts = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($one_day->date)),date('Y', strtotime($one_day->date)));

            $date = GradeWiseSalaryComponentHistory::where('grade_id',$one_day->employee->grade)->whereMonth('date','<=',$one_day->date)->whereYear('date',$one_day->date)->orderBy('id','DESC')->first();
            if(!$date){
                $date = GradeWiseSalaryComponentHistory::where('grade_id',$one_day->employee->grade)->whereYear('date','<',$one_day->date)->orderBy('id','DESC')->first();
            }
            if($date){
                $per_month_salary = GradeWiseSalaryComponentHistory::where('grade_id',$one_day->employee->grade)->where('date',$date->date)->get();
                $per_day_salary = $per_month_salary->sum('value')/$days_counts;
            }
            $date_extra = ExtraSalaryComponentHistory::where('employee_id',$one_day->employee_id)->whereMonth('date','<=',$one_day->date)->whereYear('date',$one_day->date)->orderBy('id','DESC')->first();
            if(!$date_extra){
                $date_extra = ExtraSalaryComponentHistory::where('employee_id',$one_day->employee_id)->whereYear('date','<',$one_day->date)->orderBy('id','DESC')->first();
            }
            if ($date_extra != null){
                $extra_salary_amount = ExtraSalaryComponentHistory::where('employee_id',$one_day->employee_id)->where('date',$one_day->date)->sum('value');
                $per_day_extra_salary = $extra_salary_amount/$days_counts;;
            }
            $total_amount += $per_day_salary+$per_day_extra_salary;
        }
        // employee overtime
        $employee_overtime = EmployeeOvertime::with('employee')->where('project_id', $project_id)->where('project_task_id', $task_id)->get();
        // return count($employee_overtime);
        foreach($employee_overtime as $key => $one_day){
            $days_counts = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($one_day->date)),date('Y', strtotime($one_day->date)));
            $date = GradeWiseSalaryComponentHistory::where('grade_id',$one_day->employee->grade)->whereMonth('date','<=',$one_day->date)->whereYear('date',$one_day->date)->orderBy('id','DESC')->first();
            if(!$date){
                $date = GradeWiseSalaryComponentHistory::where('grade_id',$one_day->employee->grade)->whereYear('date','<',$one_day->date)->orderBy('id','DESC')->first();
            }
            if($date){
                $basic_salary = GradeWiseSalaryComponentHistory::where('grade_id',$one_day->employee->grade)->where('date',$date->date)->where('salary_component_id',1)->get();
                $per_hours_salary = ($basic_salary->sum('value')/$days_counts)/10;
                $over_time_amount += $one_day->hours*$per_hours_salary;
            }
        }
        return $total_amount+$over_time_amount;
    }
}
