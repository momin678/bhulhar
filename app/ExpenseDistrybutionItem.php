<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseDistrybutionItem extends Model
{
    protected $guarded = [];

    public function vehicle()
    {
        return $this->belongsTo(Truck::class,'vehicle_id');
    }
    
    
    public function distribution()
    {
        return $this->belongsTo(ExpenseDistrybution::class,'expense_distrybution_id');
    }
}
