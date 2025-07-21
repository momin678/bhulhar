<?php

namespace App;

use App\Models\AccountHead;
use Illuminate\Database\Eloquent\Model;

class SaleRevenueItem extends Model
{
    public function head(){
        return $this->belongsTo(AccountHead::class,'head_id');
    }

    public function vehicle(){
        return $this->belongsTo(Truck::class,'vehicle_id');
    }
}
