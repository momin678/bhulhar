<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    public function source(){
        return $this->belongsTo(Cursher::class, 'cursher_id');
    }
    public function destination(){
        return $this->belongsTo(Destination::class, 'destination_id');
    }
    public function toll_amount($cusher, $destination){
        $toll_rates = TollRate::where('cursher_id', $cusher)->where('destination_id', $destination)->get();
        return $toll_rates->sum('amount');
    }
}
