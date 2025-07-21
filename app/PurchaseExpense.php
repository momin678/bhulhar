<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseExpense extends Model
{
        protected $guarded = [];

    public function party()
    {
        return $this->belongsTo(PartyInfo::class,'party_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseExpenseItem::class,'purchase_expense_id');

    }
    public function item()
    {
        return $this->hasOne(PurchaseExpenseItem::class,'purchase_expense_id');
    }

    public function documents(){
        return $this->hasMany(Document::class,'purchase_id');
    }
}
