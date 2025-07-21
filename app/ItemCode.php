<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCode extends Model
{
    public function vehicle_name(){
        return $this->belongsTo(VehicleName::class, 'vehicle_name_id');
    }
    public function unit(){
        return $this->belongsTo(Unit::class, 'unit_id');
    }    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function subBrand()
    {
        return $this->belongsTo(SubBrand::class, 'vehicle_model_id');
    }
}
