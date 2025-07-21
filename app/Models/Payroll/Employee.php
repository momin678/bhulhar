<?php

namespace App\Models\Payroll;

use App\TruckRecords;
use App\Country;
use App\DriverCommission;
use App\GroupCompanies;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model {

    public function items()
    {
        return $this->belongsTo(SalaryType::class, 'employee_wage_type');
    }

    public function dpt()
    {
        return $this->belongsTo(Department::class, 'department');
    }
    public function dvision()
    {
        return $this->belongsTo(Division::class, 'division');
    }

    public function div_name()
    {
        return $this->belongsTo(Division::class, 'division');
    }

    public function code()
    {
        return $this->belongsTo(Country::class, 'country_code');
    }

    public function gradeNeed()
    {
        return $this->belongsTo(Grade::class, 'grade');
    }

    public function gradeWise($id)
    {
        return GradeWiseSalaryComponent::where('grade_id',$id)->get();
    }

    public function companies()
    {
        return $this->belongsTo(GroupCompanies::class, 'company');
    }
    // public function banks()
    // {
    //     return $this->belongsTo(BankBranch::class, 'country_code');
    // }

    public function in()
    {
        $in = $this->hasMany(TimeTrack::class, 'employee_id')->orderby('id','DESC')->first();
        if ($in) {
            return $in->out == NULL?true:false;
        }
        return false;
    }

    //extra salary component
    public function extraSalaryComponent()
    {
        $extra = $this->hasMany(ExtraSalaryComponent::class, 'employee_id')->orderby('id','DESC')->get();
        // dd($in->out == NULL);
        return $extra;
    }

    public function extraCom($id)
    {
        return $this->hasMany(ExtraSalaryComponent::class,'employee_id')->where('salary_component_id',$id)->first();
    }

    public function user()
    {
        return $this->hasOne(User::class,'employee_id');
    }
    public function driver_commission(){
        return $this->hasMany(DriverCommission::class, 'driver_id')->where('is_paid', 0);
    }
    protected $guarded = [];
    public function commission($id, $from, $to){
        $records = TruckRecords::where('driver_name', $id);
        if($from && $to){
            $records = $records->whereBetween('date', [$from, $to]);
        }
        return $records->sum('commision');
    }
}
