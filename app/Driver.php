<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function driver_commission(){
        return $this->hasMany(DriverCommission::class, 'driver_id')->where('is_paid', 0);
    }
}
