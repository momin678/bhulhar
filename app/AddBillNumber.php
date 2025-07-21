<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddBillNumber extends Model
{
    public function purchase_expense_item(){
        return $this->belongsTo(PurchaseExpenseItem::class, 'bill_id');
    }
}
