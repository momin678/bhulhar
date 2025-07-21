<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function party()
    {
        return $this->belongsTo(PartyInfo::class,'party_id');
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class,'sale_id');
    }
}
