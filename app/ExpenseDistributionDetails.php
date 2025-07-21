<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseDistributionDetails extends Model
{
    protected $guarded = [];

    public function expense(){
        return $this->belongsTo(PurchaseExpense::class , 'expense_id');
    }
}
