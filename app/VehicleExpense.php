<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleExpense extends Model
{
    public function party_info(){
        return $this->belongsTo(PartyInfo::class, 'party_id');
    }
    public function truck(){
        return $this->belongsTo(Truck::class, 'vehicle_id');
    }    
    public function expense_detail_items($expense_id){
        $items = VehicleExpenseDetail::where('vehicle_expense_id', $expense_id)->get();
        return $items;
    }
}
