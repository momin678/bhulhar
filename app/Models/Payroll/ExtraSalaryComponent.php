<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;

class ExtraSalaryComponent extends Model
{
    public function components()
    {
        return $this->belongsTo(SalaryComponent::class, 'salary_component_id');
    }
    protected $guarded = [];
}
