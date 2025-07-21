<?php

namespace App;
use DB;
use App\Models\Payroll\ExtraSalaryComponentHistory;
use App\Models\Payroll\GradeWiseSalaryComponentHistory;
use Illuminate\Database\Eloquent\Model;

class JobProject extends Model
{
    protected $guarded=[];
    public function project_base_labor_expence($project_id){
        // employee attendance
        $employee_attendances = EmployeeAttendance::with('employee')->where('project_id', $project_id)->get();
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
        $employee_overtime = EmployeeOvertime::with('employee')->where('project_id', $project_id)->get();
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
        return $total_amount+$over_time_amount;
    }
    public function tasks(){
        return $this->hasMany(JobProjectTask::class);
    }

    public function party(){
        return $this->belongsTo(PartyInfo::class,'customer_id');
    }

    public function payments(){
        return $this->hasMany(JobProjectPayment::class,'job_project_id');
    }

    public function expenses(){
        return $this->hasMany(JobProjectExpense::class,'job_project_id');
    }

    public function invoicess()
    {
        return $this->hasMany(JobProjectInvoice::class,'job_project_id');
    }

    public function tem_invoices(){
        return $this->hasMany(JobProjectTemInvoice::class,'job_project_id');
    }

    public function quotation(){
        return $this->belongsTo(LpoProject::class,'lpo_projects_id');
    }

    public function project(){
        return $this->belongsTo(JobProject::class,'job_project_id');
    }

    public function purchase_expense(){
        return $this->hasMany(PurchaseExpense::class,'job_project_id');
    }


    public function bill_distribute(){
        return $this->hasMany(BillDistribute::class,'project_id');
    }

    public function temp_receipt()
    {
        $invoices = JobProjectInvoice::where('job_project_id',$this->id)->has('tempReceipt')->get();
        $sum=0;
        foreach($invoices as $inv)
        {
            $sum+=$inv->tem_receipt_amount();
        }
        return $sum;
    }

    public function temp_paid()
    {
        $invoices = PurchaseExpense::where('job_project_id',$this->id)->has('tempPayment')->get();
        $sum=0;
        foreach($invoices as $inv)
        {
            $sum+=$inv->tem_paid_amount();
        }
        return $sum;
    }
    public function project_history($projectId){
        // $project_history = DB::table('job_projects')
        //     ->select(
        //         'purchase_expenses.date as purchase_date', 'purchase_expenses.id as purchase_id', 'purchase_expenses.party_id as purchase_party_id',
        //         'job_project_invoices.date as invoice_date', 'job_project_invoices.total_budget as invoice_budget', 'job_project_invoices.customer_id as invoice_party_id'
        //     )
        //     ->leftJoin('purchase_expenses', 'job_projects.id', '=', 'purchase_expenses.job_project_id')
        //     ->leftJoin('job_project_invoices', 'job_projects.id', '=', 'job_project_invoices.job_project_id')
        //     ->where('job_projects.id', $projectId) // Filter by project ID
        //     ->orderBy(DB::raw('COALESCE(purchase_expenses.date, job_project_invoices.date)'))
        //     ->get();
        $purchase = BillDistribute::where('project_id', $projectId)->get();
        $invocie = JobProjectInvoice::where('job_project_id', $projectId)->get();
        $project_history = $purchase->merge($invocie);
        return $project_history->sortByDesc('date');
        $groupedByDate = $project_history->groupBy(function ($item) {
            // Assuming 'date' is the name of the field containing the date
            return $item->date;
        });
        dd($groupedByDate);
    }
    public function project_expense(){
        return $this->hasMany(BillDistribute::class, 'project_id')->sum('amount');
    }
}
