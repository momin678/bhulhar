<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentVoucherTemp extends Model
{
    public function party(){
        return $this->belongsTo(PartyInfo::class,'party_info_id');
    }

    public function items()
    {
        return $this->hasMany(PaymentVoucherDetailTemp::class,'payment_voucher_temp_id');
    }
    public function Cost_center(){
        return $this->belongsTo(Models\CostCenter::class, 'cost_center_id');
    }
}
