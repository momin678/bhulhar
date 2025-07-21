<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TollFees extends Model
{
    public function toll_fees_payment(){
        return $this->hasMany(TollFeesPayment::class, 'toll_fees_id');
    }
    public function toll_fees_recharge(){
        return $this->hasMany(TollFeesRecharge::class, 'toll_fees_id');
    }
    public function invoice_toll_amount(){
        return $this->hasMany(TollAmountRecord::class, 'toll_id')->where('is_invoice', 1);
    }
}
