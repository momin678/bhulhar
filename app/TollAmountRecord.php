<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TollAmountRecord extends Model
{
    public function truck_records(){
        return $this->belongsTo(TruckRecords::class, 'truck_record_id');
    }
}
