<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;

class GradeWiseSalaryComponent extends Model
{
    public function gradeComponents()
    {
        return $this->belongsTo(SalaryComponent::class, 'salary_component_id');
    }
    protected $guarded = [];
}
