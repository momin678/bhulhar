<?php

namespace App\backend;

use App\Models\Payroll\Employee;
use Illuminate\Database\Eloquent\Model;

class LabourExpenseDetail extends Model
{
    public function employee(){
        return $this->belongsTo(Employee::class, 'labour_id');
    }
}
