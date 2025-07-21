<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TollFeesRecharge extends Model
{
    public function toll_name(){
        return $this->belongsTo(TollFees::class, 'toll_fees_id');
    }
    public function party(){
        return $this->belongsTo(PartyInfo::class, 'customer_id');
    }
}
