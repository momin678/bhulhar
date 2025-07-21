<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TollFeeInvoiceItemTemp extends Model
{
    public function truck_record(){
        return $this->belongsTo(TruckRecords::class, 'item_id');
    }
    public function toll_name(){
        return $this->belongsTo(TollFees::class, 'toll_fee_id');
    }
}
