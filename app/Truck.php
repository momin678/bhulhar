<?php

namespace App;

use App\Models\Payroll\Employee;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    public function party(){
        return $this->belongsTo(PartyInfo::class,'owner');
    }
    public function driver(){
        return $this->belongsTo(Employee::class, 'driver_id');
    }
    
     public function distributed_expenses()
    {
        return $this->hasMany(ExpenseDistrybutionItem::class,'vehicle_id');
    }
}
