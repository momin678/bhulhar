<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;

class DeductionProcess extends Model {

    public function deductComponent()
    {
        return $this->belongsTo(DeductionEntry::class, 'deduction_component_id');
    }

    public function components($id, $month, $year){

        return DeductionProcess::where('employee_id',$id)->where('month',$month)->where('year',$year)->get();
    }

    protected $guarded = [];
}
