<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    public function type()
    {
        return $this->belongsTo(AssetType::class,'asset_type');
    }

    public function depreciation_record()
    {
        return $this->hasMany(AssetDepreciation::class,'asset_id');
    }

    public function sale()
    {
        return $this->hasOne(AssetSale::class,'asset_id');
    }
}
