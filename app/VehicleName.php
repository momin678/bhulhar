<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleName extends Model
{
    public function vehicle_model(){
        return $this->hasMany(SubBrand::class, 'vehicle_name_id');
    }
    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
