<?php

namespace App;

use App\Models\AccountHead;
use Illuminate\Database\Eloquent\Model;

class VehicleExpenseDetail extends Model
{
    public function ac_head(){
        return $this->belongsTo(AccountHead::class, 'ac_id');
    }
    public function item(){
        return $this->belongsTo(Product::class, 'ac_id');
    }
}
