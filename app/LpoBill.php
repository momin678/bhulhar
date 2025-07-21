<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LpoBill extends Model
{
    public function party()
    {
        return $this->belongsTo(PartyInfo::class,'party_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseExpenseItemTemp::class,'purchase_expense_id');

    }
}
