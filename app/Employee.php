<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = ['id'];

    public function type_of_employee(){
        return $this->belongsTo(TypeOfEmployee::class);
    }
    public function leave(){
        return $this->hasMany(EmployeeLeave::class, 'employee_id');
    }
}
