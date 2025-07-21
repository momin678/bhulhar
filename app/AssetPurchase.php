<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetPurchase extends Model
{
    public function supplier()
    {
        return $this->belongsTo(PartyInfo::class,'party_id');
    }

    public function items()
    {
        return $this->hasMany(Asset::class,'purchase_id');
    }
}
