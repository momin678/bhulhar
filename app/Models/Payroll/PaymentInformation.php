<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;

class PaymentInformation extends Model
{

    //relation with pay_salaries table 
    public function pay()
    {
        return $this->belongsTo(PaySalary::class, 'pay_salary_id');
    }

    //relation with employee table 
    public function emp() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    protected $guarded = [];
}
