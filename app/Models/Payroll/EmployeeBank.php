<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;

class EmployeeBank extends Model
{
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function branch()
    {
        return $this->belongsTo(BankBranch::class, 'branch_name');
    }
    protected $guarded = [];
}
