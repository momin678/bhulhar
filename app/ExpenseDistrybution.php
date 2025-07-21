<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseDistrybution extends Model
{
    protected $guarded = [];
    public function items(){
        return $this->hasMany(ExpenseDistrybutionItem::class, 'expense_distrybution_id');
    }
     public function ex_distrybution_details(){
        return $this->hasMany(ExpenseDistributionDetails::class, 'expense_distrybution_id');
    }
}
