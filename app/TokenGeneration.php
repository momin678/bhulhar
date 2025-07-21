<?php

namespace App;

use App\Models\Payroll\Employee;
use Illuminate\Database\Eloquent\Model;

class TokenGeneration extends Model
{
    public function driver(){
        return $this->belongsTo(Employee::class, 'driver_id');
    }
    public function truck(){
        return $this->belongsTo(Truck::class, 'truck_id');
    }
    public function exit_token(){
        return $this->hasOne(VehicleExpense::class, 'token_no', 'token_no');
    }
}
